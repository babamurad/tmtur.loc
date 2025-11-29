<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Translation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create inclusions table
        Schema::create('inclusions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        // 2. Create pivot table
        Schema::create('tour_inclusion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->foreignId('inclusion_id')->constrained('inclusions')->onDelete('cascade');
            $table->boolean('is_included')->default(true); // true = included, false = not included
            $table->timestamps();

            $table->unique(['tour_id', 'inclusion_id']);
        });

        // 3. Migrate Data
        $oldInclusions = DB::table('tour_inclusions')->get();

        foreach ($oldInclusions as $old) {
            // Find or create Inclusion based on the 'item' text (default locale)
            // We assume 'item' column holds the text.
            
            $inclusionId = null;
            
            // Check if we have an inclusion with this 'item' as a translation for the current app locale
            // Strategy: Check if there is already an inclusion created in this loop with the same 'item' text.
            
            $existingInclusion = DB::table('inclusions')
                ->join('translations', 'inclusions.id', '=', 'translations.translatable_id')
                ->where('translations.translatable_type', 'App\\Models\\Inclusion')
                ->where('translations.field', 'title') // New field name
                ->where('translations.value', $old->item)
                ->select('inclusions.id')
                ->first();

            if ($existingInclusion) {
                $inclusionId = $existingInclusion->id;
            } else {
                // Create new Inclusion
                $inclusionId = DB::table('inclusions')->insertGetId([
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Migrate translations
                // Old: App\Models\TourInclusion, id=$old->id, field='item'
                // New: App\Models\Inclusion, id=$inclusionId, field='title'
                
                // 1. Move existing translations
                $translations = DB::table('translations')
                    ->where('translatable_type', 'App\\Models\\TourInclusion')
                    ->where('translatable_id', $old->id)
                    ->get();

                if ($translations->isEmpty()) {
                    // If no translations found, maybe it was just in the 'item' column?
                    // Create a translation for the fallback locale using the 'item' column.
                    DB::table('translations')->insert([
                        'translatable_type' => 'App\\Models\\Inclusion',
                        'translatable_id' => $inclusionId,
                        'locale' => config('app.fallback_locale', 'ru'), // Default to ru if not set
                        'field' => 'title',
                        'value' => $old->item,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    foreach ($translations as $trans) {
                        // Check if we already have this translation for this new inclusion
                        DB::table('translations')->insert([
                            'translatable_type' => 'App\\Models\\Inclusion',
                            'translatable_id' => $inclusionId,
                            'locale' => $trans->locale,
                            'field' => 'title', // Rename 'item' to 'title'
                            'value' => $trans->value,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Create Pivot Record
            // Check if pivot exists (in case of duplicate inclusions for same tour in old data)
            $exists = DB::table('tour_inclusion')
                ->where('tour_id', $old->tour_id)
                ->where('inclusion_id', $inclusionId)
                ->exists();

            if (!$exists) {
                DB::table('tour_inclusion')->insert([
                    'tour_id' => $old->tour_id,
                    'inclusion_id' => $inclusionId,
                    'is_included' => $old->type === 'included',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // 4. Drop old table
        Schema::dropIfExists('tour_inclusions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-create old table
        Schema::create('tour_inclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->enum('type', ['included', 'not_included']);
            $table->text('item');
            $table->timestamps();
            $table->index(['tour_id', 'type']);
        });

        // Restore data (Best effort)
        $pivots = DB::table('tour_inclusion')->get();
        foreach ($pivots as $pivot) {
            $inclusion = DB::table('inclusions')->where('id', $pivot->inclusion_id)->first();
            if ($inclusion) {
                // Get translation for title
                $title = DB::table('translations')
                    ->where('translatable_type', 'App\\Models\\Inclusion')
                    ->where('translatable_id', $inclusion->id)
                    ->where('field', 'title')
                    ->where('locale', config('app.fallback_locale', 'ru'))
                    ->value('value');

                $newId = DB::table('tour_inclusions')->insertGetId([
                    'tour_id' => $pivot->tour_id,
                    'type' => $pivot->is_included ? 'included' : 'not_included',
                    'item' => $title ?? 'Unknown',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Restore translations (copy back)
                $translations = DB::table('translations')
                    ->where('translatable_type', 'App\\Models\\Inclusion')
                    ->where('translatable_id', $inclusion->id)
                    ->where('field', 'title')
                    ->get();
                    
                foreach ($translations as $trans) {
                     DB::table('translations')->insert([
                        'translatable_type' => 'App\\Models\\TourInclusion',
                        'translatable_id' => $newId,
                        'locale' => $trans->locale,
                        'field' => 'item',
                        'value' => $trans->value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        Schema::dropIfExists('tour_inclusion');
        Schema::dropIfExists('inclusions');
    }
};

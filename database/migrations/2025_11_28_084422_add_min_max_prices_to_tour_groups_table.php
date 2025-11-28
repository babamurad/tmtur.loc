<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tour_groups', function (Blueprint $table) {
            $table->integer('price_min')->nullable()->after('price_cents');
            $table->integer('price_max')->nullable()->after('price_min');
        });

        // Migrate existing data
        DB::table('tour_groups')->whereNotNull('price_cents')->chunkById(100, function ($groups) {
            foreach ($groups as $group) {
                $priceDollars = (int) round($group->price_cents / 100);
                DB::table('tour_groups')
                    ->where('id', $group->id)
                    ->update([
                        'price_min' => $priceDollars,
                        'price_max' => $priceDollars,
                    ]);
            }
        });

        Schema::table('tour_groups', function (Blueprint $table) {
            $table->dropColumn('price_cents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_groups', function (Blueprint $table) {
            $table->integer('price_cents')->nullable()->after('current_people');
        });

        // Restore data (approximate)
        DB::table('tour_groups')->whereNotNull('price_max')->chunkById(100, function ($groups) {
            foreach ($groups as $group) {
                DB::table('tour_groups')
                    ->where('id', $group->id)
                    ->update([
                        'price_cents' => $group->price_max * 100,
                    ]);
            }
        });

        Schema::table('tour_groups', function (Blueprint $table) {
            $table->dropColumn(['price_min', 'price_max']);
        });
    }
};

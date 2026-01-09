<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create route_days table
        Schema::create('route_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('routes')->cascadeOnDelete();
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->integer('day_number')->default(1);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Create new pivot tables for route_day
        Schema::create('route_day_place', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_day_id')->constrained('route_days')->cascadeOnDelete();
            $table->foreignId('place_id')->constrained('places')->cascadeOnDelete();
        });

        Schema::create('route_day_hotel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_day_id')->constrained('route_days')->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
        });

        // 3. Drop old pivot tables related to Route (if they exist from previous step)
        Schema::dropIfExists('route_place');
        Schema::dropIfExists('route_hotel');

        // 4. Clean up routes table
        Schema::table('routes', function (Blueprint $table) {
            if (Schema::hasColumn('routes', 'location_id')) {
                $table->dropForeign(['location_id']);
                $table->dropColumn('location_id');
            }
            if (Schema::hasColumn('routes', 'day_number')) {
                $table->dropColumn('day_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_day_hotel');
        Schema::dropIfExists('route_day_place');
        Schema::dropIfExists('route_days');

        Schema::table('routes', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->integer('day_number')->default(1);
        });
    }
};

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
        Schema::table('tour_itinerary_days', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
        });

        Schema::create('tour_itinerary_day_place', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_itinerary_day_id')->constrained('tour_itinerary_days')->cascadeOnDelete();
            $table->foreignId('place_id')->constrained('places')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('tour_itinerary_day_hotel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_itinerary_day_id')->constrained('tour_itinerary_days')->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_itinerary_day_hotel');
        Schema::dropIfExists('tour_itinerary_day_place');

        Schema::table('tour_itinerary_days', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }
};

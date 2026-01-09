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
        Schema::table('routes', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            if (Schema::hasColumn('routes', 'location')) {
                $table->dropColumn('location');
            }
        });

        Schema::create('route_place', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('routes')->cascadeOnDelete();
            $table->foreignId('place_id')->constrained('places')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('route_hotel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('routes')->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_hotel');
        Schema::dropIfExists('route_place');

        Schema::table('routes', function (Blueprint $table) {
            if (!Schema::hasColumn('routes', 'location')) {
                $table->string('location')->nullable();
            }
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }
};

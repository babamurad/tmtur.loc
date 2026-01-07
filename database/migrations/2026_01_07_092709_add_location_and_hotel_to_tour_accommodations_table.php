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
        Schema::table('tour_accommodations', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->after('tour_id')->constrained()->nullOnDelete();
            $table->foreignId('hotel_id')->nullable()->after('location_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_accommodations', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropForeign(['hotel_id']);
            $table->dropColumn(['location_id', 'hotel_id']);
        });
    }
};

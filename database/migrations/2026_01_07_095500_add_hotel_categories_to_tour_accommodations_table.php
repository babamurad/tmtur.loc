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
            $table->foreignId('hotel_standard_id')->nullable()->after('hotel_id')->constrained('hotels')->nullOnDelete();
            $table->foreignId('hotel_comfort_id')->nullable()->after('hotel_standard_id')->constrained('hotels')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_accommodations', function (Blueprint $table) {
            $table->dropForeign(['hotel_standard_id']);
            $table->dropForeign(['hotel_comfort_id']);
            $table->dropColumn(['hotel_standard_id', 'hotel_comfort_id']);
        });
    }
};

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
        Schema::create('tour_itinerary_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade'); // Связь с турами
            $table->tinyInteger('day_number'); // Номер дня (1, 2, 3 ...)
            $table->string('title'); // Заголовок дня (например, "Day 1: Farab – Ashgabat")
            $table->text('description'); // Подробное описание дня
            $table->timestamps();

            $table->index(['tour_id', 'day_number']); // Индекс для эффективного получения дней по туру и порядку
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_itinerary_days');
    }
};

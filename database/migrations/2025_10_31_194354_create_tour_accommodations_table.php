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
        Schema::create('tour_accommodations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade'); // Связь с турами
            $table->string('location'); // Местоположение (Ashgabat, Darvaza, etc.)
            $table->tinyInteger('nights_count'); // Количество ночей
            $table->text('standard_options')->nullable(); // Варианты стандартного уровня
            $table->text('comfort_options')->nullable(); // Варианты комфортного уровня
            $table->timestamps();

            $table->index(['tour_id', 'location']); // Индекс для эффективного получения аккомодаций по туру и локации
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_accommodations');
    }
};

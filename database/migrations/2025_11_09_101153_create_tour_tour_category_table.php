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
        Schema::create('tour_tour_category', function (Blueprint $table) {
            // 1. Внешний ключ для туров
            $table->foreignId('tour_id')
                ->constrained() // Laravel по умолчанию ищет таблицу 'tours'
                ->onDelete('cascade'); // При удалении тура удаляем и связи

            // 2. Внешний ключ для категорий
            $table->foreignId('tour_category_id')
                ->constrained() // Laravel по умолчанию ищет таблицу 'tour_categories'
                ->onDelete('cascade'); // При удалении категории удаляем и связи

            // 3. Составной первичный ключ
            // Обеспечивает, что пара (tour_id, tour_category_id) будет уникальной
            $table->primary(['tour_id', 'tour_category_id']);

            // Для таблиц pivot обычно не нужны created_at/updated_at,
            // но если нужны, добавьте: $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_tour_category');
    }
};

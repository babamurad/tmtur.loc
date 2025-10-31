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
        Schema::create('tour_inclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade'); // Связь с турами
            $table->enum('type', ['included', 'not_included']); // Тип включения
            $table->text('item'); // Описание включения/невключения
            $table->timestamps();

            $table->index(['tour_id', 'type']); // Индекс для фильтрации по туру и типу
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_inclusions');
    }
};

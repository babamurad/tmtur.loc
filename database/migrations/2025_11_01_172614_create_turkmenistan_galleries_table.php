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
        Schema::create('turkmenistan_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Заголовок
            $table->text('description')->nullable(); // Описание
            $table->string('file_path'); // Путь к файлу
            $table->string('file_name'); // Оригинальное имя файла
            $table->string('mime_type'); // MIME-тип
            $table->bigInteger('size'); // Размер в байтах
            $table->string('alt_text')->nullable(); // Альт. текст
            $table->boolean('is_featured')->default(false); // Избранное
            $table->smallInteger('order')->default(0); // Порядок
            // $table->foreignId('category_id')->nullable()->constrained('gallery_categories'); // Пример связи с категорией
            $table->string('location')->nullable(); // Местоположение
            $table->string('photographer')->nullable(); // Фотограф
            $table->timestamps();

            $table->index(['is_featured', 'order', 'created_at']); // Индекс для эффективной загрузки и сортировки
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turkmenistan_galleries');
    }
};

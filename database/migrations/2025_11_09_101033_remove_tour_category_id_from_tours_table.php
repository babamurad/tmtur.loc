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
        Schema::table('tours', function (Blueprint $table) {
            // Удаляем внешний ключ, если он существует (важно для продакшена)
            $table->dropForeign(['tour_category_id']);

            // Удаляем сам столбец
            $table->dropColumn('tour_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            // В обратной миграции возвращаем столбец и внешний ключ
            // Важно: в зависимости от ваших данных, при откате может потребоваться заполнить это поле.
            $table->foreignId('tour_category_id')
                ->nullable() // Сначала делаем nullable, чтобы избежать проблем с существующими турами без категории при откате
                ->after('slug')
                ->constrained('tour_categories')
                ->onDelete('cascade');
        });
    }
};

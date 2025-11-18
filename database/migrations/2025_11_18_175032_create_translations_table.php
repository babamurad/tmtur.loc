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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('translatable_type');      // App\Models\Tour
            $table->unsignedBigInteger('translatable_id');
            $table->string('locale', 5);              // en, ru, de ...
            $table->string('field');                  // title, description ...
            $table->text('value');
            $table->timestamps();

            // уникальный ключ на «одно поле-один язык-одна запись»
            $table->unique([
                'translatable_type',
                'translatable_id',
                'locale',
                'field'
            ], 'uniq_translation');

            // быстрая выборка всех переводов сущности
            $table->index([
                'translatable_type',
                'translatable_id'
            ], 'idx_translatable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};

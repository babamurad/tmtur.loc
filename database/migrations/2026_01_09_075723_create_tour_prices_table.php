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
        Schema::create('tour_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->string('accommodation_type')->default('standard'); // 'standard', 'comfort'
            $table->unsignedTinyInteger('min_people');
            $table->unsignedTinyInteger('max_people');
            $table->unsignedInteger('price_cents'); // Цена за человека
            $table->unsignedInteger('single_supplement_cents')->nullable(); // Доплата за одноместное
            $table->timestamps();

            // Индекс для быстрого поиска цены
            $table->index(['tour_id', 'accommodation_type', 'min_people', 'max_people'], 'tour_prices_lookup_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_prices');
    }
};

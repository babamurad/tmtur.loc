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
        Schema::table('tours', function (Blueprint $table) {
            // Фиксированные расходы на группу
            $table->unsignedInteger('cost_transport_cents')->default(0);
            $table->unsignedInteger('cost_guide_cents')->default(0);

            // Расходы на человека
            $table->unsignedInteger('cost_meal_per_day_cents')->default(0);

            // Маржа компании в процентах
            $table->decimal('company_margin_percent', 5, 2)->default(15.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn([
                'cost_transport_cents',
                'cost_guide_cents',
                'cost_meal_per_day_cents',
                'company_margin_percent'
            ]);
        });
    }
};

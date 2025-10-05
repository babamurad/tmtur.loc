<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 3 600 000 тыйн = 3 600 TMT ≈ 1 030 USD
        $priceUsd = fake()->numberBetween(180, 1_800);   // 50–500 USD
        $priceTmt = $priceUsd * 3.5;                     // курс 3.5
        $priceCents = (int)($priceTmt * 1_000);           // в тыйнах

        $durations = [1, 3, 5, 7, 8];                    // популярные длины

        return [
            'tour_category_id' => \App\Models\TourCategory::inRandomOrder()->first()->id,
            'title'            => fake()->randomElement([
                'Тур «Дары Мерва»',
                'Каньон Янгикала & Дарваза',
                'Ашхабад – беломраморная столица',
                'Дорога к «Вратам Ада»',
                'По следам Великого Шёлкового пути',
                'Джип-сафари по Кара-Куму',
                'Ахалтекинские скакуны и Ниса',
                'Праздник Навруз в Ашхабаде',
                'Бухара → Ашхабад за 5 дней',
                'Тур выходного дня: Ашхабад + Ниса',
            ]),
            'description'      => fake()->paragraphs(2, true),
            'base_price_cents' => $priceCents,
            'duration_days'    => fake()->randomElement($durations),
//            'image'            => fake()->optional()->imageUrl(800, 600, 'turkmenistan'),
        ];
    }
}

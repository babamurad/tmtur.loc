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
        // ---------- цены ----------
        $priceUsd   = fake()->numberBetween(180, 1_800); // 50–500 USD
        $priceTmt   = $priceUsd * 3.5;                   // курс 3.5
        $priceCents = (int)($priceTmt * 1_000);          // в тыйнах

        // ---------- заголовок ----------
        $title = fake()->randomElement([
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
        ]);

        // ---------- уникальный slug ----------
        $baseSlug = Str::slug($title, language: 'ru');
        do {
            $slug = $baseSlug.'-'.Str::random(4);
        } while (\App\Models\Tour::where('slug', $slug)->exists());

        return [
            'tour_category_id' => \App\Models\TourCategory::inRandomOrder()->first()->id,
            'title'            => $title,
            'slug'             => $slug,
            'description'      => fake()->paragraphs(2, true),
            'base_price_cents' => $priceCents,
            'duration_days'    => fake()->randomElement([1, 3, 5, 7, 8]),
        ];
    }
}

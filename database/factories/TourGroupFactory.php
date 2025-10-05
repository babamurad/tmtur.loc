<?php

namespace Database\Factories;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourGroup>
 */
class TourGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $max = fake()->randomElement([8, 10, 12, 16]);
        $date = fake()->dateTimeBetween('+3 weeks', '+8 months');

        // цена группы = базовая цена тура ± 10 %
        $tour = Tour::inRandomOrder()->first();
        $base = $tour->base_price_cents;
        $groupPrice = (int)($base * fake()->randomFloat(2, 0.9, 1.1));

        return [
            'tour_id'          => $tour->id,
            'starts_at'        => $date,
            'max_people'       => $max,
            'current_people'   => fake()->numberBetween(0, $max - 2),
            'price_cents'      => $groupPrice,
            'status'           => fake()->randomElement(['draft', 'open', 'closed', 'cancelled']),
        ];
    }
}

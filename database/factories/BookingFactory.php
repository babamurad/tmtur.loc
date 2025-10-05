<?php

namespace Database\Factories;

use App\Models\TourGroup;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tour_group_id' => TourGroup::factory(),
            'customer_id' => Customer::factory(),
            'people_count' => $this->faker->numberBetween(1, 5),
            'total_price_cents' => $this->faker->numberBetween(10000, 100000),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'notes' => $this->faker->optional(0.3)->sentence(),
            'confirmed_at' => $this->faker->optional(0.7)->dateTimeThisYear(),
            'cancelled_at' => function (array $attributes) {
                return $attributes['status'] === 'cancelled' 
                    ? $this->faker->dateTimeBetween($attributes['created_at'] ?? '-1 month', 'now')
                    : null;
            },
        ];
    }
}

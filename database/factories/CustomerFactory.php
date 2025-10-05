<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email'      => fake()->unique()->safeEmail(),
            'phone'      => fake()->phoneNumber(),
            'full_name'  => fake()->name(),
            'passport'   => fake()->optional()->randomElement([
                // корректный JSON-объект
                json_encode(['series' => 'PL', 'number' => (string)fake()->numberBetween(1000000, 9999999)]),
                null
            ]),
            'gdpr_consent_at' => fake()->optional()->dateTime(),
        ];
    }
}

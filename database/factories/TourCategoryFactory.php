<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourCategory>
 */
class TourCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Классические маршруты',
            'Групповые туры',
            'Индивидуальные туры',
            'Экскурсии на 1 день',
            'Заезды из Узбекистана',
        ];

        $title = fake()->unique()->randomElement($titles);

        return [
            'title'   => $title,
            'slug'    => \Str::slug($title),
            'content' => fake()->optional()->paragraph(3),
            'image'   => fake()->optional()->imageUrl(640, 480, 'tour'),
        ];
    }
}

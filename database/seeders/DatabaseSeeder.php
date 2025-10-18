<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourGroup;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\TourCategoryFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'bobo',
            'email' => 'bobo@tm.tm',
            'password' => '123123',
            'role' => '1',
        ]);
        User::factory()->create([
            'name' => 'user',
            'email' => 'bobo12@tm.tm',
            'password' => '123123',
            'role' => '0',
        ]);
        User::factory()->create([
            'name' => 'shohrateke',
            'email' => 'shohrateke@tm.tm',
            'password' => '123123',
            'role' => '1',
        ]);

        // 1. категории
        TourCategory::factory(5)->create();

        // 2. туры
        Tour::factory(15)
            ->create([
                'tour_category_id' => TourCategory::inRandomOrder()->first()->id,
            ])
            ->each(function ($tour) {
                // 3. 2-3 группы на каждый тур
                \App\Models\TourGroup::factory(rand(2, 3))
                    ->create(['tour_id' => $tour->id]);
            });

        // 3. услуги
        \App\Models\Service::factory(10)->create();

        Customer::factory(50)->create();
        Booking::factory(40)->create();

        // Запуск новых сидеров
        $this->call([
            GuideSeeder::class,
            RouteSeeder::class,
            CultureItemSeeder::class,
            ContactInfoSeeder::class,
            CarouselSlidesSeeder::class,
        ]);

        /*$cats = [
            ['title' => 'Классические маршруты', 'slug' => 'classic'],
            ['title' => 'Групповые туры',        'slug' => 'group'],
            ['title' => 'Индивидуальные туры',   'slug' => 'individual'],
            ['title' => 'Экскурсии на 1 день',   'slug' => 'day-trip'],
            ['title' => 'Заезды из Узбекистана', 'slug' => 'from-uzb'],
        ];

        foreach ($cats as $cat) {
            \App\Models\TourCategory::create($cat);
        }*/
    }
}

<?php

namespace Database\Seeders;

use App\Models\Guide;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guide::create([
            'name' => 'Айна',
            'description' => 'Сертифицированный гид с 10-летним опытом',
            'image' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&h=400&q=80',
            'languages' => ['ru', 'en', 'tm'],
            'specialization' => 'История и культура Туркменистана',
            'experience_years' => 10,
            'is_active' => true,
            'sort_order' => 1
        ]);

        Guide::create([
            'name' => 'Мерет',
            'description' => 'Историк, специалист по Великому Шелковому пути',
            'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&h=400&q=80',
            'languages' => ['ru', 'en', 'tm'],
            'specialization' => 'Великий Шелковый путь',
            'experience_years' => 8,
            'is_active' => true,
            'sort_order' => 2
        ]);

        Guide::create([
            'name' => 'Арслан',
            'description' => 'Эксперт по природным достопримечательностям',
            'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&h=400&q=80',
            'languages' => ['ru', 'en', 'tm'],
            'specialization' => 'Природные достопримечательности',
            'experience_years' => 6,
            'is_active' => true,
            'sort_order' => 3
        ]);
    }
}

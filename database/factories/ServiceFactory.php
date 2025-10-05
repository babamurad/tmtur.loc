<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = [
            ['name' => 'Виза поддержка',                'type' => 'visa',       'price' =>  60],
            ['name' => 'Трансфер а/п Ашхабад',         'type' => 'transfer',   'price' =>  40],
            ['name' => 'Внутренний перелёт АШБ–Мары',  'type' => 'flight',     'price' => 120],
            ['name' => 'Гид на 1 день (EN)',           'type' => 'guide',      'price' =>  80],
            ['name' => 'Гид на 1 день (RU)',           'type' => 'guide',      'price' =>  80],
            ['name' => 'Ужин в пустыне у кратера',    'type' => 'excursion',  'price' =>  35],
            ['name' => 'Страховка TravelGuard 7 дн.', 'type' => 'insurance',  'price' =>  25],
            ['name' => 'Отель 4* (1 ночь)',            'type' => 'hotel',      'price' =>  90],
            ['name' => 'Джип 4×1 день',                'type' => 'excursion',  'price' => 180],
            ['name' => 'Вечернее шоу в Ашхабаде',      'type' => 'excursion',  'price' =>  50],
        ];

        $item = fake()->randomElement($services);

        return [
            'name'              => $item['name'],
            'type'              => $item['type'],
            'default_price_cents' => $item['price'] * 1_000, // USD → тыйны
        ];
    }
}

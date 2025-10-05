<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Route::create([
            'title' => 'День 1: Прибытие в Ашхабад',
            'description' => 'Встреча в аэропорту, трансфер в отель. Обзорная экскурсия по "городу любви" - Ашхабаду с его беломраморными зданиями и впечатляющими памятниками.',
            'day_number' => 1,
            'location' => 'Ашхабад',
            'activities' => 'Встреча в аэропорту, трансфер, обзорная экскурсия',
            'is_active' => true,
            'sort_order' => 1
        ]);

        Route::create([
            'title' => 'День 2: Ашхабад - Ниса',
            'description' => 'Посещение древней парфянской крепости Ниса, объекта Всемирного наследия ЮНЕСКО. Знакомство с Национальным музеем ковра.',
            'day_number' => 2,
            'location' => 'Ниса',
            'activities' => 'Экскурсия в Нису, посещение музея ковра',
            'is_active' => true,
            'sort_order' => 2
        ]);

        Route::create([
            'title' => 'День 3: Ашхабад - Дарваза',
            'description' => 'Путешествие к знаменитым газовым кратерам Дарваза, известным как "Врата Ада". Ночлег в юрточном лагере.',
            'day_number' => 3,
            'location' => 'Дарваза',
            'activities' => 'Переезд в Дарваза, осмотр кратеров, ночлег в юртах',
            'is_active' => true,
            'sort_order' => 3
        ]);

        Route::create([
            'title' => 'День 4: Дарваза - Куня-Ургенч',
            'description' => 'Переезд в Куня-Ургенч - древнюю столицу Хорезма. Осмотр мавзолеев и минаретов XI-XIV веков.',
            'day_number' => 4,
            'location' => 'Куня-Ургенч',
            'activities' => 'Переезд, осмотр исторических памятников',
            'is_active' => true,
            'sort_order' => 4
        ]);

        Route::create([
            'title' => 'День 5: Куня-Ургенч - Дашогуз - Ашхабад',
            'description' => 'Возвращение в Ашхабад с остановкой в Дашогузе. Свободное время для покупки сувениров.',
            'day_number' => 5,
            'location' => 'Дашогуз, Ашхабад',
            'activities' => 'Возвращение в Ашхабад, покупка сувениров',
            'is_active' => true,
            'sort_order' => 5
        ]);

        Route::create([
            'title' => 'День 6: Ашхабад - Мерв',
            'description' => 'Экскурсия в древний Мерв - один из старейших городов Центральной Азии, важный пункт Великого Шелкового пути.',
            'day_number' => 6,
            'location' => 'Мерв',
            'activities' => 'Экскурсия в древний Мерв',
            'is_active' => true,
            'sort_order' => 6
        ]);

        Route::create([
            'title' => 'День 7: Вылет из Ашхабада',
            'description' => 'Трансфер в аэропорт и вылет домой с незабываемыми впечатлениями о загадочном Туркменистане.',
            'day_number' => 7,
            'location' => 'Ашхабад',
            'activities' => 'Трансфер в аэропорт, вылет',
            'is_active' => true,
            'sort_order' => 7
        ]);
    }
}

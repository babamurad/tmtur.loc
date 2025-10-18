<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarouselSlidesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('carousel_slides')->insert([
            [
                'id' => 6,
                'title' => 'Врата Ада: Путешествие к Дарвазе',
                'description' => 'Погрузитесь в огненное сердце пустыни Каракумы. Тур, который меняет представление о мире.',
                'image' => 'carousel/1760056973.jpg',
                'button_text' => 'Смотреть туры в Дарвазу',
                'button_link' => 'http://tmtur.loc/',
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => '2025-10-09 21:42:53',
                'updated_at' => '2025-10-09 23:45:14',
            ],
            [
                'id' => 7,
                'title' => 'Эхо Великого Шелкового пути',
                'description' => 'Откройте для себя руины древнего Мерва и Нисы. Исследуйте наследие цивилизаций.',
                'image' => 'carousel/1760057032.jpg',
                'button_text' => 'Выбрать исторический маршрут',
                'button_link' => 'http://tmtur.loc',
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => '2025-10-09 21:43:52',
                'updated_at' => '2025-10-09 21:43:52',
            ],
            [
                'id' => 8,
                'title' => 'Ахал-Теке: Знакомство с Небесными Конями',
                'description' => 'Увидьте легендарных скакунов Туркменистана — символ нации и ее гордость.',
                'image' => 'carousel/1760057091.jpg',
                'button_text' => 'Планировать индивидуальный тур',
                'button_link' => 'http://tmtur.loc',
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => '2025-10-09 21:44:51',
                'updated_at' => '2025-10-09 21:44:51',
            ],
        ]);
    }
}

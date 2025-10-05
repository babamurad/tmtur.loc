<?php

namespace Database\Seeders;

use App\Models\CultureItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CultureItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CultureItem::create([
            'title' => 'Исламская архитектура',
            'description' => 'Величественные мечети и мавзолеи, украшенные изразцами и резьбой, отражают богатое духовное наследие туркменского народа.',
            'icon' => 'fas fa-mosque',
            'is_active' => true,
            'sort_order' => 1
        ]);

        CultureItem::create([
            'title' => 'Ковроткачество',
            'description' => 'Туркменские ковры известны worldwide своим качеством и уникальными узорами, передающимися из поколения в поколение.',
            'icon' => 'fas fa-carpet',
            'is_active' => true,
            'sort_order' => 2
        ]);

        CultureItem::create([
            'title' => 'Традиционная кухня',
            'description' => 'От ароматного плова до самсы и знаменитого туркменского чая - гастрономические традиции порадуют любого гурмана.',
            'icon' => 'fas fa-teapot',
            'is_active' => true,
            'sort_order' => 3
        ]);
    }
}

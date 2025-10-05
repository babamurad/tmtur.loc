<?php

namespace Database\Seeders;

use App\Models\ContactInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactInfo::create([
            'type' => 'whatsapp',
            'label' => 'WhatsApp',
            'value' => '+993-12-345-678',
            'icon' => 'fab fa-whatsapp',
            'is_active' => true,
            'sort_order' => 1
        ]);

        ContactInfo::create([
            'type' => 'telegram',
            'label' => 'Telegram',
            'value' => '+993-12-345-678',
            'icon' => 'fab fa-telegram',
            'is_active' => true,
            'sort_order' => 2
        ]);

        ContactInfo::create([
            'type' => 'phone',
            'label' => 'Телефон',
            'value' => '+993-12-345-678',
            'icon' => 'fas fa-phone',
            'is_active' => true,
            'sort_order' => 3
        ]);

        ContactInfo::create([
            'type' => 'social',
            'label' => 'Facebook',
            'value' => 'https://facebook.com/turkmentravel',
            'icon' => 'fab fa-facebook',
            'is_active' => true,
            'sort_order' => 4
        ]);

        ContactInfo::create([
            'type' => 'social',
            'label' => 'Instagram',
            'value' => 'https://instagram.com/turkmentravel',
            'icon' => 'fab fa-instagram',
            'is_active' => true,
            'sort_order' => 5
        ]);
    }
}

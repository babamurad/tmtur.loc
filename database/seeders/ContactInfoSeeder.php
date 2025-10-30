<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactInfo;

class ContactInfoSeeder extends Seeder
{
    public function run()
    {
        ContactInfo::truncate();

        ContactInfo::create([
            'type' => 'address',
            'label' => 'Address',
            'value' => 'Ashgabat, Magtymguly Ave., 123',
            'icon' => 'bx bx-map',
            'sort_order' => 1,
            'input_type' => 'text',
        ]);

        ContactInfo::create([
            'type' => 'phone',
            'label' => 'Phone',
            'value' => '+993 12 34 56 78',
            'icon' => 'bx bx-phone',
            'sort_order' => 2,
            'input_type' => 'text',
        ]);

        ContactInfo::create([
            'type' => 'email',
            'label' => 'Email',
            'value' => 'info@turkmentravel.com',
            'icon' => 'bx bx-envelope',
            'sort_order' => 3,
            'input_type' => 'text',
        ]);

        ContactInfo::create([
            'type' => 'hours',
            'label' => 'Working hours',
            'value' => "Mon–Fri: 9:00–18:00\nSat: 10:00–15:00\nSun: closed",
            'icon' => 'bx bx-time',
            'sort_order' => 4,
            'input_type' => 'textarea',
        ]);
    }
}

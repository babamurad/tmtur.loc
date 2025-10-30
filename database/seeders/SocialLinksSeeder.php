<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialLink;

class SocialLinksSeeder extends Seeder
{
    public function run()
    {
        SocialLink::truncate();

        SocialLink::create([
            'name' => 'Facebook',
            'url' => '#',
            'icon' => 'bxl-facebook',
            'btn_class' => 'btn-fb',
            'sort_order' => 1,
        ]);
        SocialLink::create([
            'name' => 'Twitter',
            'url' => '#',
            'icon' => 'bxl-twitter',
            'btn_class' => 'btn-tw',
            'sort_order' => 2,
        ]);
        SocialLink::create([
            'name' => 'Instagram',
            'url' => '#',
            'icon' => 'bxl-instagram',
            'btn_class' => 'btn-ig',
            'sort_order' => 3,
        ]);
        SocialLink::create([
            'name' => 'YouTube',
            'url' => '#',
            'icon' => 'bxl-youtube',
            'btn_class' => 'btn-yt',
            'sort_order' => 4,
        ]);
        SocialLink::create([
            'name' => 'WhatsApp',
            'url' => 'https://wa.me/99362846733',
            'icon' => '',
            'btn_class' => 'btn-ws',
            'sort_order' => 5,
        ]);
    }
}

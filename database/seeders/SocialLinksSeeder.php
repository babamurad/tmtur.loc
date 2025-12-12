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
            'url' => 'https://facebook.com',
            'icon' => 'fab fa-facebook-f',
            'btn_class' => 'btn-primary',
            'sort_order' => 1,
        ]);
        SocialLink::create([
            'name' => 'Twitter',
            'url' => 'https://twitter.com',
            'icon' => 'fab fa-twitter',
            'btn_class' => 'btn-info',
            'sort_order' => 2,
        ]);
        SocialLink::create([
            'name' => 'Instagram',
            'url' => 'https://instagram.com',
            'icon' => 'fab fa-instagram',
            'btn_class' => 'btn-danger',
            'sort_order' => 3,
        ]);
        SocialLink::create([
            'name' => 'YouTube',
            'url' => 'https://youtube.com',
            'icon' => 'fab fa-youtube',
            'btn_class' => 'btn-danger',
            'sort_order' => 4,
        ]);
        SocialLink::create([
            'name' => 'WhatsApp',
            'url' => 'https://wa.me/99362846733',
            'icon' => 'fab fa-whatsapp',
            'btn_class' => 'btn-success',
            'sort_order' => 5,
        ]);
        SocialLink::create([
            'name' => 'Telegram',
            'url' => 'https://t.me',
            'icon' => 'fab fa-telegram',
            'btn_class' => 'btn-info',
            'sort_order' => 6,
        ]);
        SocialLink::create([
            'name' => 'LinkedIn',
            'url' => 'https://linkedin.com',
            'icon' => 'fab fa-linkedin-in',
            'btn_class' => 'btn-primary',
            'sort_order' => 7,
        ]);
        SocialLink::create([
            'name' => 'TikTok',
            'url' => 'https://tiktok.com',
            'icon' => 'fab fa-tiktok',
            'btn_class' => 'btn-dark',
            'sort_order' => 8,
        ]);
    }
}

<?php

namespace App\Support;

class SocialIcons
{
    /**
     * Возвращает массив иконок FA5 (brands) для соцсетей.
     * Ключ — класс иконки, значение — html-представление (иконка + пробел + текст)
     */
    public static function all(): array
    {
        return [
            // Основные соцсети
            'fab fa-facebook-f' => '<i class="fab fa-facebook-f"></i> Facebook',
            'fab fa-x' => '<i class="fab fa-x"></i> X',
            'fab fa-twitter' => '<i class="fab fa-twitter"></i> Twitter',
            'fab fa-instagram' => '<i class="fab fa-instagram"></i> Instagram',
            'fab fa-youtube' => '<i class="fab fa-youtube"></i> YouTube',
            'fab fa-whatsapp' => '<i class="fab fa-whatsapp"></i> WhatsApp',
            'fab fa-telegram' => '<i class="fab fa-telegram"></i> Telegram',
            'fab fa-linkedin-in' => '<i class="fab fa-linkedin-in"></i> LinkedIn',
            'fab fa-odnoklassniki' => '<i class="fab fa-odnoklassniki"></i> Odnoklassniki',
            'fab fa-vk' => '<i class="fab fa-vk"></i> VK',
            'fab fa-pinterest' => '<i class="fab fa-pinterest"></i> Pinterest',
            'fab fa-tiktok' => '<i class="fab fa-tiktok"></i> TikTok',
            'fab fa-snapchat' => '<i class="fab fa-snapchat"></i> Snapchat',
            // Можно добавить ещё при необходимости
        ];
    }
}

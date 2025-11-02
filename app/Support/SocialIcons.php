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
            'fab fa-x' => '<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" transform="" id="injected-svg"><!--Boxicons v3.0.3 https://boxicons.com | License  https://docs.boxicons.com/free--><path d="M13.68 10.62 20.24 3h-1.55L13 9.62 8.45 3H3.19l6.88 10.01L3.19 21h1.55l6.01-6.99 4.8 6.99h5.24l-7.13-10.38Zm-2.13 2.47-.7-1-5.54-7.93H7.7l4.47 6.4.7 1 5.82 8.32H16.3z"></path></svg> X',
            'fab fa-twitter' => '<i class="fab fa-twitter"></i> Twitter',
            'fab fa-instagram' => '<i class="fab fa-instagram"></i> Instagram',
            'fab fa-youtube' => '<i class="fab fa-youtube"></i> YouTube',
            'fab fa-whatsapp' => '<i class="fab fa-whatsapp"></i> WhatsApp',
            'fab fa-telegram' => '<i class="fab fa-telegram"></i> Telegram',
            'fab fa-linkedin-in' => '<i class="fab fa-linkedin-in"></i> LinkedIn',
            'fab fa-odnoklassniki' => '<i class="fab fa-odnoklassniki"></i> Odnoklassniki',
            'fab fa-vk' => '<i class="fab fa-vk"></i> VK',
            'fab fa-pinterest' => '<i class="fab fa-pinterest"></i> Pinterest',
            'fab fa-tiktok' => '<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24" transform="" id="injected-svg"><!--Boxicons v3.0.3 https://boxicons.com | License  https://docs.boxicons.com/free--><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 3 3 0 0 1 .88.13V9.4a7 7 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a5 5 0 0 1-1-.1z"></path></svg>  TikTok',
            'fab fa-snapchat' => '<i class="fab fa-snapchat"></i> Snapchat',
            'fab fa-google-plus' => '<i class="fab fa-google-plus"></i> Google+',
            // Можно добавить ещё при необходимости
        ];
    }
}

<?php
declare(strict_types=1);

namespace App\Support;

final class AvailableLanguages
{
    private const FILE = 'bootstrap/languages.json';

    /* ---------- чтение ---------- */
    public static function all(): array
    {
        $path = base_path(self::FILE);
        if (!file_exists($path)) {   // на всякий случай
            return [];
        }
        return json_decode(file_get_contents($path), true);
    }

    /* ---------- добавить ---------- */
    public static function add(string $code, string $name): void
    {
        $list = self::all();
        $list[$code] = $name;
        file_put_contents(
            base_path(self::FILE),
            json_encode($list, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }

    /* ---------- удалить ---------- */
    public static function remove(string $code): void
    {
        $list = self::all();
        unset($list[$code]);
        file_put_contents(
            base_path(self::FILE),
            json_encode($list, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }
}

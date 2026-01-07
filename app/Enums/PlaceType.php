<?php

namespace App\Enums;

enum PlaceType: string
{
    case PAID = 'paid';
    case FREE = 'free';

    public function label(): string
    {
        return match ($this) {
            self::PAID => 'Paid',
            self::FREE => 'Free',
        };
    }

    public static function options(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}

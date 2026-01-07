<?php

namespace App\Enums;

enum HotelCategory: string
{
    case STANDARD = 'standard';
    case COMFORT = 'comfort';

    public function label(): string
    {
        return match ($this) {
            self::STANDARD => 'Standard',
            self::COMFORT => 'Comfort',
        };
    }

    public static function options(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}

<?php

namespace App\Enums;

enum AccommodationType: string
{
    case STANDARD = 'standard';
    case COMFORT = 'comfort';

    public function label(): string
    {
        return match ($this) {
            self::STANDARD => 'Стандарт',
            self::COMFORT => 'Комфорт',
        };
    }
}

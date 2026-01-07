<?php

namespace App\Enums;

enum HotelCategory: string
{
    case STANDARD = 'standard';
    case COMFORT = 'comfort';

    public function label(): string
    {
        return match ($this) {
            self::STANDARD => __('locations.category_standard'),
            self::COMFORT => __('locations.category_comfort'),
        };
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}

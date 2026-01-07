<?php

namespace App\Enums;

enum PlaceType: string
{
    case PAID = 'paid';
    case FREE = 'free';

    public function label(): string
    {
        return match ($this) {
            self::PAID => __('locations.type_paid'),
            self::FREE => __('locations.type_free'),
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

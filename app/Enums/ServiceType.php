<?php

namespace App\Enums;

final class ServiceType
{
    public const FLIGHT     = 'flight';
    public const VISA       = 'visa';
    public const HOTEL      = 'hotel';
    public const EXCURSION  = 'excursion';
    public const GUIDE      = 'guide';
    public const TRANSFER   = 'transfer';
    public const INSURANCE  = 'insurance';

    /**
     * Для выпадающих списков: [value => label]
     */
    public static function options(): array
    {
        return [
            self::FLIGHT    => 'Flight',
            self::VISA      => 'Visa',
            self::HOTEL     => 'Hotel',
            self::EXCURSION => 'Excursion',
            self::GUIDE     => 'Guide',
            self::TRANSFER  => 'Transfer',
            self::INSURANCE => 'Insurance',
        ];
    }

    /**
     * Для валидации: 'in:' . ServiceType::ruleIn()
     */
    public static function ruleIn(): string
    {
        return implode(',', array_values((new \ReflectionClass(self::class))->getConstants()));
    }
}
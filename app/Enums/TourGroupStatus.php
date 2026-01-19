<?php

namespace App\Enums;

enum TourGroupStatus: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case FULL = 'full';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::OPEN => 'Открыт',
            self::CLOSED => 'Закрыт',
            self::FULL => 'Заполнен',
            self::CANCELLED => 'Отменен',
            self::COMPLETED => 'Завершен',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::OPEN => 'success',
            self::CLOSED => 'secondary',
            self::FULL => 'warning',
            self::CANCELLED => 'danger',
            self::COMPLETED => 'info',
        };
    }
}

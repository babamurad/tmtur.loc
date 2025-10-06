<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ServiceType;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'default_price_cents',
    ];

    protected $casts = [
        'type' => 'string',          // native string
        'default_price_cents' => 'integer',
    ];

    public function typeLabel(): string
    {
        return ServiceType::options()[$this->type] ?? ucfirst($this->type);
    }

    public function tourGroupServices()
    {
        return $this->hasMany(TourGroupService::class);
    }

    public function bookingServices()
    {
        return $this->hasMany(BookingService::class);
    }
}

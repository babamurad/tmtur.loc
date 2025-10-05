<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'default_price_cents',
    ];
    public function tourGroupServices()
    {
        return $this->hasMany(TourGroupService::class);
    }

    public function bookingServices()
    {
        return $this->hasMany(BookingService::class);
    }
}

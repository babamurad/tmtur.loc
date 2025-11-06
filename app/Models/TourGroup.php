<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'starts_at',
        'max_people',
        'current_people',
        'price_cents',
        'status',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function groupServices()
    {
        return $this->hasMany(TourGroupService::class);
    }

    public function TourGroup()
    {
        return $this->belongsToMany(TourGroup::class);
    }
}

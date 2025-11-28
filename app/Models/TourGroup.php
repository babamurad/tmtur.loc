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
        'price_min',
        'price_max',
        'status',
    ];

    public function getPriceForPeople(int $peopleCount): int
    {
        if ($peopleCount <= 1) {
            return $this->price_max;
        }

        if ($peopleCount >= $this->max_people) {
            return $this->price_min;
        }

        // Linear interpolation
        // P = Pmax - (Pmax - Pmin) * (N - 1) / (Nmax - 1)
        $priceDiff = $this->price_max - $this->price_min;
        $peopleDiff = $this->max_people - 1;
        
        if ($peopleDiff <= 0) return $this->price_max;

        $discountPerPerson = $priceDiff / $peopleDiff;
        $currentPeopleDiff = $peopleCount - 1;

        return (int) round($this->price_max - ($discountPerPerson * $currentPeopleDiff));
    }

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

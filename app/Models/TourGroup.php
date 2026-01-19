<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\AccommodationType;

class TourGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tour_id',
        'starts_at',
        'max_people',
        'current_people',
        'price_min',
        'price_max',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => \App\Enums\TourGroupStatus::class,
            'starts_at' => 'date',
        ];
    }

    /**
     * @param int $peopleCount
     * @param string $accommodationType
     * @return int
     */
    public function getPriceForPeople(int $peopleCount, string $accommodationType = 'standard'): int
    {
        if ($accommodationType === 'standard' && defined('App\Enums\AccommodationType::STANDARD')) {
            $accommodationType = AccommodationType::STANDARD->value;
        }
        // 1. Try to find strict price from matrix
        $price = $this->tour->prices()
            ->where('accommodation_type', $accommodationType)
            ->where('min_people', '<=', $peopleCount)
            ->where('max_people', '>=', $peopleCount)
            ->value('price_cents');

        if ($price) {
            return (int) $price;
        }

        // 2. Fallback to old logic (Linear interpolation) if no matrix entry found
        //    Legacy logic only supports 'standard' price (no accommodation differentiation properly)

        if ($peopleCount <= 1) {
            return $this->price_max;
        }

        if ($this->max_people > 0 && $peopleCount >= $this->max_people) {
            return $this->price_min;
        }

        // Linear interpolation
        // P = Pmax - (Pmax - Pmin) * (N - 1) / (Nmax - 1)
        $priceDiff = $this->price_max - $this->price_min;
        $peopleDiff = $this->max_people - 1;

        if ($peopleDiff <= 0)
            return $this->price_max;

        $discountPerPerson = $priceDiff / $peopleDiff;
        $currentPeopleDiff = $peopleCount - 1;

        return (int) round($this->price_max - ($discountPerPerson * $currentPeopleDiff));
    }

    public function freePlaces()
    {
        return $this->max_people - $this->current_people;
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function tourGroupServices()
    {
        return $this->hasMany(TourGroupService::class);
    }
}

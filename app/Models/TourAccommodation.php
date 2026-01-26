<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Translatable;
use App\Traits\HasSeo;

class TourAccommodation extends Model
{
    use HasFactory, Translatable, HasSeo;

    public $fields = ['location', 'standard_options', 'comfort_options'];

    protected $fillable = [
        'tour_id',
        'location_id',
        'hotel_id', // Deprecated
        'hotel_standard_id',
        'hotel_comfort_id',
        'location', // Deprecated
        'nights_count',
        'standard_options', // Deprecated (likely unused now)
        'comfort_options', // Deprecated (likely unused now)
    ];

    // Связь: аккомодация принадлежит одному туру
    public function tour(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function locationModel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function hotel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function hotelStandard(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_standard_id');
    }

    public function hotelComfort(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_comfort_id');
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'accommodation_hotel')
            ->withPivot('type')
            ->withTimestamps();
    }

    public function standardHotels()
    {
        return $this->hotels()->wherePivot('type', 'standard');
    }

    public function comfortHotels()
    {
        return $this->hotels()->wherePivot('type', 'comfort');
    }
}

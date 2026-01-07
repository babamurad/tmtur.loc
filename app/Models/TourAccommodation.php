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
        'hotel_id',
        'location', // Keeping for backward compatibility or if manual entry is needed
        'nights_count',
        'standard_options',
        'comfort_options',
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
}

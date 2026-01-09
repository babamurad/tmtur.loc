<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourPrice extends Model
{
    protected $fillable = [
        'tour_id',
        'accommodation_type',
        'min_people',
        'max_people',
        'price_cents',
        'single_supplement_cents',
    ];

    protected $casts = [
        'price_cents' => 'integer',
        'single_supplement_cents' => 'integer',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}

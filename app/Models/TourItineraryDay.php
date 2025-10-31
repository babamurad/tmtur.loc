<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourItineraryDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'day_number',
        'title',
        'description',
    ];

    // Связь: один день итинерария принадлежит одному туру
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}

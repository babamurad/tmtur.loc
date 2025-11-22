<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Translatable;

class TourItineraryDay extends Model
{
    use HasFactory, Translatable;

    public $fields = ['title', 'description'];

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

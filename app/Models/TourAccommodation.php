<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Translatable;

class TourAccommodation extends Model
{
    use HasFactory, Translatable;

    public $fields = ['location', 'standard_options', 'comfort_options'];

    protected $fillable = [
        'tour_id',
        'location',
        'nights_count',
        'standard_options',
        'comfort_options',
    ];

    // Связь: аккомодация принадлежит одному туру
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}

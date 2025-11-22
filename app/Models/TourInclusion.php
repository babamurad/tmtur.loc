<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Translatable;

class TourInclusion extends Model
{
    use HasFactory, Translatable;

    public $fields = ['item'];

    protected $fillable = [
        'tour_id',
        'type',
        'item',
    ];

    // Связь: включение принадлежит одному туру
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}

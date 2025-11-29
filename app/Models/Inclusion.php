<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Translatable;

class Inclusion extends Model
{
    use HasFactory, Translatable;

    public $fields = ['title'];

    protected $fillable = [
        'title', // This might be used for fallback or just as a placeholder if Translatable uses it
    ];

    // Relationship with Tours
    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'tour_inclusion')
            ->withPivot('is_included')
            ->withTimestamps();
    }
}

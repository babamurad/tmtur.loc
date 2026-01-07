<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\HotelCategory;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['location_id', 'name', 'category'];

    protected $casts = [
        'category' => HotelCategory::class,
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}

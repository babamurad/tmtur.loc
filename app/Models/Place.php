<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\PlaceType;

class Place extends Model
{
    use HasFactory;

    protected $fillable = ['location_id', 'name', 'type', 'cost'];

    protected $casts = [
        'type' => PlaceType::class,
        'cost' => 'decimal:2',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}

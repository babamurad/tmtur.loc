<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\PlaceType;
use App\Models\Traits\Translatable;

class Place extends Model
{
    use HasFactory, Translatable;

    public $fields = ['name'];

    protected $fillable = ['location_id', 'name', 'type', 'cost'];

    protected $casts = [
        'type' => PlaceType::class,
        'cost' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::deleted(fn($model) => $model->translations()->delete());
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}

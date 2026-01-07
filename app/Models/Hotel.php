<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\HotelCategory;
use App\Models\Traits\Translatable;

class Hotel extends Model
{
    use HasFactory, Translatable;

    public $fields = ['name'];

    protected $fillable = ['location_id', 'name', 'category'];

    protected $casts = [
        'category' => HotelCategory::class,
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

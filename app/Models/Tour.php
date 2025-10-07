<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'map_id',
        'base_price_cents',
        'duration_days',
        'slug',
        'tour_category_id'
    ];

    protected $casts = [
        'description' => 'array',
        'base_price_cents' => 'integer',
        'duration_days' => 'integer',
        'slug' => 'string',
        'tour_category_id' => 'integer'
    ];

    public function tourCategory(): BelongsTo
    {
        return $this->belongsTo(TourCategory::class, 'tour_category_id');
    }

    public function tourGroups(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TourGroup::class);
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }
    // Tour
    public function media()
    {
        return $this->hasOne(Media::class, 'model_id', 'id')
                    ->where('model_type', Tour::class);
    }
}

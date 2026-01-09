<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'activities',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function days()
    {
        return $this->hasMany(RouteDay::class)->orderBy('day_number');
    }

    // Proxy to get route string from days
    public function getRouteStringAttribute(): string
    {
        return $this->days->loadMissing('location')
            ->pluck('location.name')
            ->filter()
            ->unique()
            ->join(' → ');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}

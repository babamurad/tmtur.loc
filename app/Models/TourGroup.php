<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'tour_id',
        'starts_at',
        'max_people',
        'current_people',
        'price_cents',
        'status'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'max_people' => 'integer',
        'current_people' => 'integer',
        'price_cents' => 'integer'
    ];

    public function tour(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function tourGroupServices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TourGroupService::class);
    }

    public function bookings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Booking::class);
    }
}

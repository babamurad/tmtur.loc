<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_group_id',
        'customer_id',
        'people_count',
        'total_price_cents',
        'status',
        'notes',
        'confirmed_at',
        'cancelled_at'
    ];

    protected $casts = [
        'people_count' => 'integer',
        'total_price_cents' => 'integer',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    public function tourGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TourGroup::class);
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function bookingServices(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BookingService::class);
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_services');
    }
}

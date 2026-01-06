<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedLink extends Model
{
    protected $fillable = [
        'target_url',
        'source',
        'full_url',
        'click_count',
    ];

    public function clicks()
    {
        return $this->hasMany(\App\Models\GeneratedLinkClick::class);
    }

    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class);
    }

    public function payouts()
    {
        return $this->hasMany(\App\Models\GeneratedLinkPayout::class);
    }

    public function getTotalEarningsAttribute()
    {
        // $20 per booking
        return $this->bookings()->where('status', '!=', 'cancelled')->count() * 20;
    }

    public function getTotalPaidAttribute()
    {
        return $this->payouts()->sum('amount');
    }

    public function getBalanceAttribute()
    {
        return $this->total_earnings - $this->total_paid;
    }
}

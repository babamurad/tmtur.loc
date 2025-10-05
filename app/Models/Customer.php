<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone',
        'full_name',
        'passport',
        'gdpr_consent_at',
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

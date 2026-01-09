<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'location_id',
        'day_number',
        'title',
        'description',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function places()
    {
        return $this->belongsToMany(Place::class, 'route_day_place');
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'route_day_hotel');
    }
}

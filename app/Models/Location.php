<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class);
    }

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }
}

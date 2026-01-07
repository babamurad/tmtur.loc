<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Traits\Translatable;

class Location extends Model
{
    use HasFactory, Translatable;

    public $fields = ['name', 'description'];

    protected $fillable = ['name', 'slug', 'description'];

    protected static function booted()
    {
        static::deleted(fn($model) => $model->translations()->delete());
    }

    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class);
    }

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }
}

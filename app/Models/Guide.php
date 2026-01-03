<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guide extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'languages',
        'specialization',
        'experience_years',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'languages' => 'array',
        'is_active' => 'boolean',
        'experience_years' => 'integer',
        'sort_order' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    public function media()
    {
        return $this->hasOne(Media::class, 'model_id', 'id')
            ->where('model_type', Tour::class);
    }
}

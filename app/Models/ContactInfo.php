<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\Translatable;

class ContactInfo extends Model
{
    use HasFactory;
    use Translatable;

    public $fields = ['label', 'value'];

    protected $fillable = [
        'type', 'label', 'value', 'icon', 'is_active', 'sort_order', 'input_type', 'url'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    protected static function booted()
    {
        static::deleted(fn ($model) => $model->translations()->delete());
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }
}

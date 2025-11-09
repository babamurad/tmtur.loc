<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourCategory extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'image', 'is_published'];

    protected $casts = [
        'is_published' => 'boolean'
    ];

    /**
     * Отношение "многие ко многим" с турами.
     */
    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(
            Tour::class,
            'tour_tour_category',   // ваша таблица
            'tour_category_id',     // внешний ключ категории
            'tour_id'               // внешний ключа тура
        );
    }
}

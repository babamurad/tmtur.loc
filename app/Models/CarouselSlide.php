<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarouselSlide extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'title',
        'description',
        'image',
        'button_text',
        'button_link',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Поля, доступные для перевода
     */
    public $fields = ['title', 'description', 'button_text'];

    /**
     * Scope для получения только активных слайдов
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope для сортировки по порядку
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    /**
     * Получить все активные слайды, отсортированные по порядку
     */
    public static function getActiveSlides()
    {
        return self::active()->ordered()->get();
    }
}

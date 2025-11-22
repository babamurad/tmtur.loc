<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tour extends Model
{
    use HasFactory;
    use Translatable;

    public $fields = ['title', 'short_description'];

    protected $fillable = [
        'title',
        'slug',
//        'tour_category_id',
        'short_description',
        'is_published',
        'base_price_cents',
        'duration_days',
    ];

    protected $casts = [
        'description' => 'array',
        'base_price_cents' => 'integer',
        'duration_days' => 'integer',
        'slug' => 'string',
        'tour_category_id' => 'integer'
    ];

//    public function category(): BelongsTo
//    {
//        return $this->belongsTo(TourCategory::class, 'tour_category_id');
//    }

    protected static function booted()
    {
        static::deleted(fn ($model) => $model->translations()->delete());
    }

    /**
     * Отношение "многие ко многим" с категориями.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            TourCategory::class,
            'tour_tour_category',   // явно та же таблица
            'tour_id',              // внешний ключ тура
            'tour_category_id'      // внешний ключ категории
        );
    }

    /**
     * Отношение "многие ко многим" с категориями.
     */
    public function tourGroups(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TourGroup::class);
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }
    // Tour
    public function media()
    {
        return $this->hasOne(Media::class, 'model_id', 'id')
                    ->where('model_type', Tour::class);
    }

    public function getFirstMediaUrl($collectionName = 'default')
    {
        $media = $this->media;

        if (!$media) {
            return asset('assets/images/media/no-image.jpg'); // Путь к изображению по умолчанию
        }

        // Возвращаем URL к изображению
        return asset('uploads/' . $media->file_path);
    }

    public function groupsOpen()
    {
        return $this->hasMany(TourGroup::class)
            ->where('status', 'open')
            ->where('starts_at', '>', now())
            ->orderBy('starts_at');
    }

    // Связь: тур может иметь много дней итинерария
    public function itineraryDays()
    {
        return $this->hasMany(TourItineraryDay::class)->orderBy('day_number');
    }

    // Связь: тур может иметь много включений
    public function inclusions()
    {
        return $this->hasMany(TourInclusion::class);
    }

    // Связь: тур может иметь много вариантов аккомодации
    public function accommodations()
    {
        return $this->hasMany(TourAccommodation::class);
    }

    // Связь: тур может иметь много групп
    public function groups()
    {
        return $this->hasMany(TourGroup::class);
    }

    // Связь: тур может иметь много услуг через группы (опционально, если нужно через промежуточную таблицу)
     public function services()
     {
         return $this->hasManyThrough(Service::class, TourGroup::class);
     }
}

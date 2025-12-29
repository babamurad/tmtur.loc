<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\HasSeo;

class Tour extends Model
{
    use HasSeo;
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
        static::deleted(fn($model) => $model->translations()->delete());
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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tour_tag');
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
    // Tour - все медиафайлы
    public function media()
    {
        return $this->hasMany(Media::class, 'model_id', 'id')
            ->where('model_type', Tour::class);
    }

    // Медиафайлы, отсортированные по order
    public function orderedMedia()
    {
        return $this->hasMany(Media::class, 'model_id', 'id')
            ->where('model_type', Tour::class)
            ->orderBy('order');
    }

    public function getFirstMediaUrl($collectionName = 'default')
    {
        $media = $this->orderedMedia()->first();

        if (!$media) {
            return asset('assets/images/media/no-image.jpg'); // Путь к изображению по умолчанию
        }

        // Возвращаем URL к изображению
        return asset('uploads/' . $media->file_path);
    }

    // Accessor для удобного использования в Blade
    public function getFirstMediaUrlAttribute(): string
    {
        $img = $this->orderedMedia()->first();
        return $img
            ? asset('uploads/' . $img->file_path)
            : asset('assets/images/media/no-image.jpg');
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

    // Связь: тур может иметь много включений (Многие ко Многим)
    public function inclusions()
    {
        return $this->belongsToMany(Inclusion::class, 'tour_inclusion')
            ->withPivot('is_included')
            ->withTimestamps();
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

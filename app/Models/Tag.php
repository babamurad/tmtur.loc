<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Traits\Translatable;

class Tag extends Model
{
    use HasFactory;
    use Translatable;

    public $fields = ['name'];

    protected $fillable = ['name'];

    protected $casts = [
        'name' => 'array',
    ];

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'tour_tag');
    }

    public function tr(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->$field;

        if (is_array($value)) {
            return $value[$locale] ?? $value[config('app.fallback_locale')] ?? \Illuminate\Support\Arr::first($value) ?? null;
        }

        return $value;
    }

    public function setTr(string $field, string $locale, ?string $value): void
    {
        $current = $this->$field;
        if (!is_array($current)) {
            $current = [];
        }

        $current[$locale] = $value;
        $this->$field = $current;
        $this->save();
    }

    public function hasTranslation(string $field, string $locale): bool
    {
        $current = $this->$field;
        return is_array($current) && isset($current[$locale]) && trim($current[$locale] ?? '') !== '';
    }
}

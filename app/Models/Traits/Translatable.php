<?php

namespace App\Models\Traits;

use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

trait Translatable
{
    /**
     * Получить перевод поля для текущей или указанной локали.
     * Если перевода нет — вернёт оригинальное значение поля.
     */
    public function tr(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();

        // Optimisation: use eager loaded relation if available
        if ($this->relationLoaded('translations')) {
            $translation = $this->translations
                ->first(function ($t) use ($field, $locale) {
                    return $t->field === $field && $t->locale === $locale;
                });

            return $translation ? $translation->value : $this->$field;
        }

        $key = "t.{$locale}." . static::class . ".{$this->id}.{$field}";

        return Cache::remember($key, now()->addDay(), function () use ($field, $locale) {
            $translation = Translation::where([
                'translatable_type' => static::class,
                'translatable_id' => $this->id,
                'locale' => $locale,
                'field' => $field,
            ])->value('value');

            return $translation ?? $this->$field;
        });
    }

    /**
     * Сохранить / обновить перевод.
     */
    public function setTr(string $field, string $locale, ?string $value): void
    {
        Translation::updateOrCreate(
            [
                'translatable_type' => static::class,
                'translatable_id' => $this->id,
                'locale' => $locale,
                'field' => $field,
            ],
            ['value' => $value]
        );

        $this->flushTrCache();   // ← сброс
    }

    /**
     * Все переводы этой записи (если понадобится).
     */
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function flushTrCache(): void
    {
        foreach (config('app.available_locales') as $locale) {
            foreach ($this->fields ?? ['title', 'description'] as $field) {
                Cache::forget("t.{$locale}." . static::class . ".{$this->id}.{$field}");
            }
        }
    }
}

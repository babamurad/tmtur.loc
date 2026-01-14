<?php

namespace App\Livewire\Tours;

use App\Models\Tour;
use App\Models\TourCategory;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Media;
use App\Services\ImageService;
use App\Models\TourItineraryDay;
use App\Models\Inclusion; // Changed from TourInclusion
use App\Models\TourAccommodation;
use App\Models\Location;
use App\Models\Hotel;
use App\Services\GeminiTranslationService;

class TourEditComponent extends Component
{
    use WithFileUploads;

    public Tour $tour;

    /* Основные поля */
    public string $title = '';
    public ?string $slug = null;
    public array $category_id = [];
    public bool $is_published = true;
    public ?int $base_price_cents = null;
    public ?int $duration_days = null;


    /* Изображения */
    public $newImages = [];        // новые загружаемые изображения
    public $existingImages = [];   // текущие изображения из БД
    public $imagesToDelete = [];   // ID изображений для удаления

    /* Динамические массивы */
    public array $itinerary_days = [];
    public array $inclusions = [];
    public array $available_inclusions = []; // List of all available inclusions
    public array $accommodations = [];
    public array $tags_selected = [];
    /* мультиязычные значения */
    public array $trans = [];   // [ru][title], [en][title] …

    // SEO
    public $seo_title;
    public $seo_description;

    public $last_translation_duration;

    /* Правила */
    protected function rules(): array
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|min:3|max:255|unique:tours,slug,' . $this->tour->id,
            'category_id' => 'required|array|min:1',
            'category_id.*' => 'integer|exists:tour_categories,id',
            'is_published' => 'boolean',
            'base_price_cents' => 'required|integer|min:0',
            'duration_days' => 'required|integer|min:1',
            'newImages' => 'nullable|array',
            'newImages.*' => 'nullable|image|max:2048',

            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',

            'itinerary_days' => 'nullable|array',
            'itinerary_days.*.day_number' => 'required|integer|min:1',
            'itinerary_days.*.location_id' => 'nullable|exists:locations,id',
            'itinerary_days.*.place_ids' => 'nullable|array',
            'itinerary_days.*.place_ids.*' => 'exists:places,id',
            'itinerary_days.*.hotel_ids' => 'nullable|array',
            'itinerary_days.*.hotel_ids.*' => 'exists:hotels,id',

            'inclusions' => 'nullable|array',
            'inclusions.*.inclusion_id' => 'required|exists:inclusions,id',
            'inclusions.*.is_included' => 'required|boolean',

            'accommodations' => 'nullable|array',
            'accommodations.*.nights_count' => 'required|integer|min:1',

            'tags_selected' => 'nullable|array',
            'tags_selected.*' => 'integer|exists:tags,id',
        ];

        /* переводы для основного тура */
        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'required|string|max:255';
            $rules["trans.$l.short_description"] = 'nullable|string';
        }

        /* переводы для дней итинерария */
        foreach (config('app.available_locales') as $l) {
            $rules["itinerary_days.*.trans.$l.title"] = 'required|string|max:255';
            $rules["itinerary_days.*.trans.$l.description"] = 'nullable|string';
        }

        // Removed translation rules for inclusions

        $rules['accommodations.*.location_id'] = 'required|exists:locations,id';
        $rules['accommodations.*.hotel_standard_id'] = 'nullable|exists:hotels,id';
        $rules['accommodations.*.hotel_comfort_id'] = 'nullable|exists:hotels,id';

        return $rules;
    }

    protected function messages(): array
    {
        $messages = [];

        foreach (config('app.available_locales') as $locale) {
            $langName = strtoupper($locale);
            $messages["trans.$locale.title.required"] = "Название на $langName обязательно для заполнения";
            $messages["trans.$locale.title.max"] = "Название на $langName не должно превышать 255 символов";
        }

        return $messages;
    }

    protected $listeners = ['quillUpdated' => 'updateQuillField'];

    public function attributes(): array
    {
        $attributes = [
            'title' => 'Название',
            'slug' => 'Slug',
            'category_id' => 'Категория',
            'is_published' => 'Опубликовано',
            'base_price_cents' => 'Цена',
            'duration_days' => 'Длительность',
            'newImages' => 'Изображения',
            'newImages.*' => 'Изображение',
            'seo_title' => 'SEO Заголовок',
            'seo_description' => 'SEO Описание',
            'tags_selected' => 'Теги',
        ];

        foreach (config('app.available_locales') as $locale) {
            $lang = strtoupper($locale);
            $attributes["trans.$locale.title"] = "Название ($lang)";
            $attributes["trans.$locale.short_description"] = "Краткое описание ($lang)";
        }

        foreach ($this->itinerary_days as $index => $day) {
            $num = $index + 1;
            $attributes["itinerary_days.$index.day_number"] = "День $num: Номер";
            $attributes["itinerary_days.$index.location_id"] = "День $num: Локация";
            $attributes["itinerary_days.$index.place_ids"] = "День $num: Места";
            $attributes["itinerary_days.$index.hotel_ids"] = "День $num: Отели";

            foreach (config('app.available_locales') as $locale) {
                $lang = strtoupper($locale);
                $attributes["itinerary_days.$index.trans.$locale.title"] = "День $num: Заголовок ($lang)";
                $attributes["itinerary_days.$index.trans.$locale.description"] = "День $num: Описание ($lang)";
            }
        }

        foreach ($this->inclusions as $index => $inc) {
            $num = $index + 1;
            $attributes["inclusions.$index.inclusion_id"] = "Включение $num";
            $attributes["inclusions.$index.is_included"] = "Включение $num (Тип)";
        }

        foreach ($this->accommodations as $index => $acc) {
            $num = $index + 1;
            $attributes["accommodations.$index.nights_count"] = "Размещение $num: Ночей";
            $attributes["accommodations.$index.location_id"] = "Размещение $num: Локация";
        }

        return $attributes;
    }

    public function updateQuillField($data)
    {
        data_set($this, $data['field'], $data['value']);
    }


    public function mount(int $id)
    {
        $tour = Tour::findOrFail($id);
        $this->tour = $tour;

        $this->title = $tour->title;
        $this->slug = $tour->slug;
        $this->is_published = $tour->is_published;
        $this->base_price_cents = $tour->base_price_cents;
        $this->duration_days = $tour->duration_days;

        if ($tour->seo) {
            $this->seo_title = $tour->seo->title;
            $this->seo_description = $tour->seo->description;
        }

        $this->category_id = $tour->categories->pluck('id')->toArray();

        // Загружаем существующие изображения
        $this->existingImages = $tour->orderedMedia->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => asset('uploads/' . $media->file_path),
                'file_path' => $media->file_path,
                'file_name' => $media->file_name,
                'order' => $media->order,
            ];
        })->toArray();

        // Загружаем дни итинерария с переводами и связями
        $tour->load(['itineraryDays.places', 'itineraryDays.hotels']);
        $this->itinerary_days = $tour->itineraryDays->map(function ($item) {
            $trans = [];
            foreach (config('app.available_locales') as $locale) {
                $trans[$locale] = [
                    'title' => $item->tr('title', $locale),
                    'description' => $item->tr('description', $locale),
                ];
            }
            return [
                'id' => $item->id,
                'day_number' => $item->day_number,
                'location_id' => $item->location_id,
                'place_ids' => $item->places->pluck('id')->toArray(),
                'hotel_ids' => $item->hotels->pluck('id')->toArray(),
                'trans' => $trans
            ];
        })->all();

        // Загружаем доступные включения
        $this->available_inclusions = Inclusion::all()->all();

        // Загружаем привязанные включения
        $this->inclusions = $tour->inclusions->map(function ($item) {
            return [
                'inclusion_id' => $item->id,
                'is_included' => $item->pivot->is_included,
            ];
        })->all();

        // Загружаем размещение
        $this->accommodations = $tour->accommodations->map(function ($item) {
            return [
                'id' => $item->id,
                'nights_count' => $item->nights_count,
                'location_id' => $item->location_id,
                'hotel_standard_id' => $item->hotel_standard_id,
                'hotel_comfort_id' => $item->hotel_comfort_id,
            ];
        })->all();

        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = $this->tour->tr('title', $locale);
            $this->trans[$locale]['short_description'] = $this->tour->tr('short_description', $locale);
        }

        // Load Tags
        // Load Tags
        $this->tags_selected = $this->tour->tags->pluck('id')->toArray();
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    public function updated($property, $value)
    {
        // When location changes in itinerary, clear selected places and hotels
        if (Str::startsWith($property, 'itinerary_days') && Str::endsWith($property, 'location_id')) {
            $parts = explode('.', $property);
            if (isset($parts[1])) {
                $index = $parts[1];
                $this->itinerary_days[$index]['place_ids'] = [];
                $this->itinerary_days[$index]['hotel_ids'] = [];
            }
        }
    }

    // === Методы для Itinerary Days ===
    public function addItineraryDay()
    {
        $trans = [];
        foreach (config('app.available_locales') as $locale) {
            $trans[$locale] = [
                'title' => '',
                'description' => ''
            ];
        }

        $this->itinerary_days[] = [
            'day_number' => count($this->itinerary_days) + 1,
            'location_id' => null,
            'place_ids' => [],
            'hotel_ids' => [],
            'trans' => $trans
        ];
    }

    public function removeItineraryDay($index)
    {
        unset($this->itinerary_days[$index]);
        $this->itinerary_days = array_values($this->itinerary_days);
    }

    // === Методы для Inclusions ===
    public function addInclusion()
    {
        $this->inclusions[] = [
            'inclusion_id' => '',
            'is_included' => 1
        ];
    }

    public function removeInclusion($index)
    {
        unset($this->inclusions[$index]);
        $this->inclusions = array_values($this->inclusions);
    }

    // === Методы для Accommodations ===
    public function addAccommodation()
    {
        $this->accommodations[] = [
            'nights_count' => 1,
            'location_id' => null,
            'hotel_standard_id' => null,
            'hotel_comfort_id' => null,
        ];
    }

    public function removeAccommodation($index)
    {
        unset($this->accommodations[$index]);
        $this->accommodations = array_values($this->accommodations);
    }

    // === Методы для управления галереей ===
    public function makeMain($mediaId)
    {
        $media = Media::where('model_type', Tour::class)
            ->where('model_id', $this->tour->id)
            ->findOrFail($mediaId);

        // Сдвигаем все на +1, что были до выбранной
        $this->tour->media()->where('order', '<', $media->order)->increment('order');

        // Ставим выбранную на 0
        $media->update(['order' => 0]);

        // Перезагружаем список
        $this->existingImages = $this->tour->fresh()->orderedMedia->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => asset('uploads/' . $media->file_path),
                'file_path' => $media->file_path,
                'file_name' => $media->file_name,
                'order' => $media->order,
            ];
        })->toArray();

        LivewireAlert::title('Главное изображение')
            ->text('Изображение установлено как главное.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function deleteImage($mediaId)
    {
        $this->imagesToDelete[] = $mediaId;

        // Удаляем из отображаемого списка
        $this->existingImages = array_filter($this->existingImages, function ($img) use ($mediaId) {
            return $img['id'] !== $mediaId;
        });
        $this->existingImages = array_values($this->existingImages);
    }

    public function undoDelete($mediaId)
    {
        $this->imagesToDelete = array_filter($this->imagesToDelete, function ($id) use ($mediaId) {
            return $id !== $mediaId;
        });

        // Перезагружаем список
        $this->existingImages = $this->tour->fresh()->orderedMedia
            ->whereNotIn('id', $this->imagesToDelete)
            ->map(function ($media) {
                return [
                    'id' => $media->id,
                    'url' => asset('uploads/' . $media->file_path),
                    'file_path' => $media->file_path,
                    'file_name' => $media->file_name,
                    'order' => $media->order,
                ];
            })->toArray();
    }

    // === Методы для AI-перевода ===

    /**
     * Автоперевод на английский через Gemini AI
     */
    /**
     * Helper to gather all fields, translate them in one batch, and assign back.
     */
    protected function performBatchTranslation(GeminiTranslationService $translator, string $targetLangCode, string $targetLangName)
    {
        $fallbackLocale = config('app.fallback_locale');
        $availableLocales = config('app.available_locales');

        // 1. Prepare Source Data - Sync local props to Fallback Locale in Trans array
        if (!empty($this->title)) {
            $this->trans[$fallbackLocale]['title'] = $this->title;
        }

        // 2. Smart Source Detection: Find the first locale that has a Title
        $sourceLocale = null;

        // Check Fallback first as priority if filled
        if (!empty($this->trans[$fallbackLocale]['title'])) {
            $sourceLocale = $fallbackLocale;
        } else {
            // Check others
            foreach ($availableLocales as $locale) {
                if (!empty($this->trans[$locale]['title'])) {
                    $sourceLocale = $locale;
                    break;
                }
            }
        }

        if (!$sourceLocale) {
            LivewireAlert::title('Ошибка')
                ->text('Заполните данные хотя бы на одном языке перед переводом.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }

        if ($sourceLocale === $targetLangCode) {
            return;
        }

        // 3. Aggregate fields from the Source Locale
        $fieldsToTranslate = [];

        // Main fields
        $fieldsToTranslate['main_title'] = $this->trans[$sourceLocale]['title'];
        $fieldsToTranslate['main_desc'] = $this->trans[$sourceLocale]['short_description'] ?? '';

        // Itinerary fields
        foreach ($this->itinerary_days as $index => $day) {
            $dayTitle = $day['trans'][$sourceLocale]['title'] ?? '';
            $dayDesc = $day['trans'][$sourceLocale]['description'] ?? '';

            // Use unique keys for each day field
            $fieldsToTranslate["day_{$index}_title"] = $dayTitle;
            $fieldsToTranslate["day_{$index}_desc"] = $dayDesc;
        }

        \Illuminate\Support\Facades\Log::info("Gemini Batch Input ({$targetLangName}):", $fieldsToTranslate);

        // 4. Call Service ONCE
        $startTime = microtime(true);
        $translated = $translator->translateFields($fieldsToTranslate, $targetLangName, 'Тур и программа тура');

        // Save duration
        $this->last_translation_duration = round(microtime(true) - $startTime, 2);

        \Illuminate\Support\Facades\Log::info("Gemini Batch Output ({$targetLangName}):", $translated);

        if (empty($translated)) {
            LivewireAlert::title('Ошибка')
                ->text("Не удалось получить перевод на $targetLangName. Проверьте логи.")
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }

        // 5. Map Results Back

        // Main
        if (isset($translated['main_title'])) {
            $this->trans[$targetLangCode]['title'] = $translated['main_title'];
            if ($targetLangCode === config('app.fallback_locale')) {
                $this->title = $translated['main_title'];
            }
        }
        if (isset($translated['main_desc'])) {
            $this->trans[$targetLangCode]['short_description'] = $translated['main_desc'];
        }

        // Itinerary
        foreach ($this->itinerary_days as $index => $day) {
            if (isset($translated["day_{$index}_title"])) {
                $this->itinerary_days[$index]['trans'][$targetLangCode]['title'] = $translated["day_{$index}_title"];
            }
            if (isset($translated["day_{$index}_desc"])) {
                $this->itinerary_days[$index]['trans'][$targetLangCode]['description'] = $translated["day_{$index}_desc"];
            }
        }

        $this->dispatch('refresh-quill');

        LivewireAlert::title('Перевод выполнен')
            ->text("Перевод на $targetLangName успешно выполнен!")
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    /**
     * Автоперевод на английский через Gemini AI
     */
    public function autoTranslateToEnglish(GeminiTranslationService $translator)
    {
        $this->performBatchTranslation($translator, 'en', 'English');
    }

    /**
     * Автоперевод на корейский через Gemini AI
     */
    public function autoTranslateToKorean(GeminiTranslationService $translator)
    {
        $this->performBatchTranslation($translator, 'ko', 'Korean');
    }

    /**
     * Автоперевод на все языки сразу
     */
    public function translateToAllLanguages(GeminiTranslationService $translator)
    {
        $names = [
            'ru' => 'Russian',
            'en' => 'English',
            'ko' => 'Korean',
        ];

        foreach (config('app.available_locales') as $locale) {
            $this->performBatchTranslation($translator, $locale, $names[$locale] ?? ucfirst($locale));
        }
    }

    public function save()
    {
        $fallback = config('app.fallback_locale');
        $this->trans[$fallback]['title'] = $this->title;

        $this->validate();

        // 1. только технические / не-переводимые поля
        // обновляем оригинал значением fallback-языка
        $fallbackLocale = config('app.fallback_locale');
        $this->tour->update([
            'title' => $this->trans[$fallbackLocale]['title'],
            'short_description' => $this->trans[$fallbackLocale]['short_description'] ?? '',
            'is_published' => $this->is_published,
            'base_price_cents' => $this->base_price_cents,
            'duration_days' => $this->duration_days,
        ]);

        // Сохраняем SEO
        $this->tour->seo()->updateOrCreate([], [
            'title' => $this->seo_title,
            'description' => $this->seo_description,
        ]);

        // сохраняем переводы (включая fallback – на всякий случай)
        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                // Пропускаем пустые значения - не сохраняем переводы без перевода
                if ($value !== null && $value !== '') {
                    $this->tour->setTr($field, $locale, $value);
                }
            }
        }

        // 3. сброс кэша
        $this->tour->flushTrCache();

        $this->tour->categories()->sync($this->category_id);

        // Process Tags
        if ($this->tags_selected) {
            $this->tour->tags()->sync($this->tags_selected);
        } else {
            $this->tour->tags()->detach();
        }

        // Itinerary
        $keepDays = [];
        foreach ($this->itinerary_days as $dayData) {
            $fallbackLocale = config('app.fallback_locale');
            $day = TourItineraryDay::updateOrCreate(
                ['id' => $dayData['id'] ?? null, 'tour_id' => $this->tour->id],
                [
                    'day_number' => $dayData['day_number'],
                    'title' => $dayData['trans'][$fallbackLocale]['title'] ?? '',
                    'description' => $dayData['trans'][$fallbackLocale]['description'] ?? '',
                    'location_id' => $dayData['location_id'] ?? null,
                ]
            );

            if (isset($dayData['place_ids'])) {
                $day->places()->sync($dayData['place_ids']);
            }
            if (isset($dayData['hotel_ids'])) {
                $day->hotels()->sync($dayData['hotel_ids']);
            }

            // Сохраняем переводы
            foreach ($dayData['trans'] as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    // Пропускаем пустые значения
                    if ($value !== null && $value !== '') {
                        $day->setTr($field, $locale, $value);
                    }
                }
            }

            $keepDays[] = $day->id;
        }
        TourItineraryDay::where('tour_id', $this->tour->id)
            ->whereNotIn('id', $keepDays)->delete();

        // Inclusions Sync
        $syncData = [];
        foreach ($this->inclusions as $incData) {
            if (!empty($incData['inclusion_id'])) {
                $syncData[$incData['inclusion_id']] = ['is_included' => $incData['is_included']];
            }
        }
        $this->tour->inclusions()->sync($syncData);

        // Accommodations
        $keepAcc = [];
        foreach ($this->accommodations as $a) {
            $fallbackLocale = config('app.fallback_locale');
            $acc = TourAccommodation::updateOrCreate(
                ['id' => $a['id'] ?? null, 'tour_id' => $this->tour->id],
                [
                    'nights_count' => $a['nights_count'],
                    'location_id' => $a['location_id'] ?? null,
                    'hotel_id' => $a['hotel_id'] ?? null,
                    'location' => '', // Deprecated
                    // 'standard_options' => ..., // Removed
                    // 'comfort_options' => ..., // Removed
                ]
            );

            $acc = TourAccommodation::updateOrCreate(
                ['id' => $a['id'] ?? null, 'tour_id' => $this->tour->id],
                [
                    'nights_count' => $a['nights_count'],
                    'location_id' => $a['location_id'] ?? null,
                    'hotel_standard_id' => $a['hotel_standard_id'] ?? null,
                    'hotel_comfort_id' => $a['hotel_comfort_id'] ?? null,
                ]
            );

            // Removing translation saving loop as standard/comfort options are removed

            $keepAcc[] = $acc->id;
        }
        TourAccommodation::where('tour_id', $this->tour->id)
            ->whereNotIn('id', $keepAcc)->delete();

        // Image - удаление помеченных
        foreach ($this->imagesToDelete as $mediaId) {
            $media = Media::find($mediaId);
            if ($media) {
                Storage::disk('public_uploads')->delete($media->file_path);
                $media->delete();
            }
        }

        // Загрузка новых изображений
        if ($this->newImages && count($this->newImages) > 0) {
            $orderBase = $this->tour->media()->max('order') + 1;

            $imageService = new ImageService();
            foreach ($this->newImages as $idx => $file) {
                $optimized = $imageService->saveOptimized($file, 'tours/' . $this->tour->id);

                Media::create([
                    'model_type' => Tour::class,
                    'model_id' => $this->tour->id,
                    'file_path' => $optimized['path'],
                    'file_name' => $optimized['file_name'],
                    'mime_type' => $optimized['mime_type'],
                    'size' => $optimized['size'],
                    'order' => $orderBase + $idx,
                ]);
            }
        }

        // Если у тура нет картинки с order = 0 – делаем первую главной
        if ($this->tour->media()->where('order', 0)->doesntExist()) {
            $this->tour->media()->oldest('id')->limit(1)->update(['order' => 0]);
        }

        LivewireAlert::title('Сохранение')
            ->text('Изменения успешно сохранены.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();

    }

    public function saveAndClose()
    {
        $this->save();
        session()->flash('saved', [
            'title' => 'Тур обновлён!',
            'text' => 'Все изменения сохранены.',
        ]);

        return redirect()->route('admin.tours.index');
    }

    public function render()
    {
        $categories = TourCategory::select('id', 'title')->get();
        $tags = \App\Models\Tag::all();
        $locations = Location::orderBy('name')->with(['hotels', 'places'])->get();

        return view('livewire.tours.tour-edit-component', [
            'categories' => $categories,
            'tags' => $tags,
            'locations' => $locations,
        ]);
    }
}

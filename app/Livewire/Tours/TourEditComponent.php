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

        // Загружаем дни итинерария с переводами
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
    public function autoTranslateToEnglish(GeminiTranslationService $translator)
    {
        $fallbackLocale = config('app.fallback_locale');

        if (empty($this->trans[$fallbackLocale]['title'])) {
            session()->flash('error', 'Заполните русскую версию перед переводом.');
            return;
        }

        $translations = $translator->translateFields([
            'title' => $this->trans[$fallbackLocale]['title'],
            'short_description' => $this->trans[$fallbackLocale]['short_description'] ?? '',
        ], 'English', 'Тур');

        if ($translations['title']) {
            $this->trans['en']['title'] = $translations['title'];
            $this->trans['en']['short_description'] = $translations['short_description'];

            LivewireAlert::title('Перевод выполнен')
                ->text('Перевод на английский успешно выполнен!')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        } else {
            LivewireAlert::title('Ошибка перевода')
                ->text('Не удалось выполнить перевод. Попробуйте позже.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    /**
     * Автоперевод на корейский через Gemini AI
     */
    public function autoTranslateToKorean(GeminiTranslationService $translator)
    {
        $fallbackLocale = config('app.fallback_locale');

        if (empty($this->trans[$fallbackLocale]['title'])) {
            session()->flash('error', 'Заполните русскую версию перед переводом.');
            return;
        }

        $translations = $translator->translateFields([
            'title' => $this->trans[$fallbackLocale]['title'],
            'short_description' => $this->trans[$fallbackLocale]['short_description'] ?? '',
        ], 'Korean', 'Тур');

        if ($translations['title']) {
            $this->trans['ko']['title'] = $translations['title'];
            $this->trans['ko']['short_description'] = $translations['short_description'];

            LivewireAlert::title('Перевод выполнен')
                ->text('Перевод на корейский успешно выполнен!')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        } else {
            LivewireAlert::title('Ошибка перевода')
                ->text('Не удалось выполнить перевод. Попробуйте позже.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    /**
     * Автоперевод на все языки сразу
     */
    public function translateToAllLanguages(GeminiTranslationService $translator)
    {
        $fallbackLocale = config('app.fallback_locale');

        if (empty($this->trans[$fallbackLocale]['title'])) {
            session()->flash('error', 'Заполните русскую версию перед переводом.');
            return;
        }

        // Перевод на английский
        $englishTranslations = $translator->translateFields([
            'title' => $this->trans[$fallbackLocale]['title'],
            'short_description' => $this->trans[$fallbackLocale]['short_description'] ?? '',
        ], 'English', 'Тур');

        if ($englishTranslations['title']) {
            $this->trans['en']['title'] = $englishTranslations['title'];
            $this->trans['en']['short_description'] = $englishTranslations['short_description'];
        }

        // Перевод на корейский
        $koreanTranslations = $translator->translateFields([
            'title' => $this->trans[$fallbackLocale]['title'],
            'short_description' => $this->trans[$fallbackLocale]['short_description'] ?? '',
        ], 'Korean', 'Тур');

        if ($koreanTranslations['title']) {
            $this->trans['ko']['title'] = $koreanTranslations['title'];
            $this->trans['ko']['short_description'] = $koreanTranslations['short_description'];
        }

        if ($englishTranslations['title'] && $koreanTranslations['title']) {
            LivewireAlert::title('Перевод выполнен')
                ->text('Переводы на все языки успешно выполнены!')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        } else {
            LivewireAlert::title('Частичный перевод')
                ->text('Некоторые переводы не удалось выполнить.')
                ->warning()
                ->toast()
                ->position('top-end')
                ->show();
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
                ]
            );

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
        $locations = Location::orderBy('name')->with('hotels')->get();

        return view('livewire.tours.tour-edit-component', [
            'categories' => $categories,
            'tags' => $tags,
            'locations' => $locations,
        ]);
    }
}

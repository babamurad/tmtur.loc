<?php

namespace App\Livewire\Tours;


use App\Models\Tour;
use App\Models\TourCategory;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;
use Carbon\Carbon;
use App\Services\ImageService;
use App\Models\TourItineraryDay;
use App\Models\Inclusion; // Changed from TourInclusion
use App\Models\TourAccommodation;
use App\Models\Location;
use App\Models\Hotel;
use App\Services\GeminiTranslationService;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class TourCreateComponent extends Component
{
    use WithFileUploads;

    // Основные поля тура
    public $title;
    public $slug;
    public $category_id = [];
    public $short_description = '';
    public $images = [];
    public $is_published = true;
    public $base_price_cents;
    public $duration_days;

    // Поля для итинерария
    public $itinerary_days = [];

    // Поля для включений
    public $inclusions = [];
    public $available_inclusions = []; // List of all available inclusions

    // Поля для аккомодаций
    public $accommodations = [];

    // Теги
    public $tags_selected = [];

    // SEO поля
    public $seo_title;
    public $seo_description;

    /* мультиязычные значения */
    public array $trans = [];

    protected function rules()
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|min:3|max:255|unique:tours,slug',
            'short_description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'base_price_cents' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',

            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',

            'itinerary_days.*.day_number' => 'required|integer|min:1',

            // Updated rules for inclusions
            'inclusions.*.inclusion_id' => 'required|exists:inclusions,id',
            'inclusions.*.is_included' => 'required|boolean',

            'accommodations.*.nights_count' => 'required|integer|min:1',

            'category_id' => 'required|array|min:1',
            'category_id.*' => 'integer|exists:tour_categories,id',

            'tags_selected' => 'nullable|array',
            'tags_selected.*' => 'integer|exists:tags,id',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'required|string|max:255';
            $rules["trans.$l.short_description"] = 'nullable|string';
        }

        foreach (config('app.available_locales') as $l) {
            $rules["itinerary_days.*.trans.$l.title"] = 'required|string|max:255';
            $rules["itinerary_days.*.trans.$l.description"] = 'nullable|string';
        }

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

    public function mount()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = '';
            $this->trans[$locale]['short_description'] = '';
        }

        $this->available_inclusions = Inclusion::all();

        // Автоматически добавляем все включения при создании тура
        foreach ($this->available_inclusions as $inclusion) {
            $this->inclusions[] = [
                'inclusion_id' => $inclusion->id,
                'is_included' => 1 // По умолчанию все включения отмечены как включенные
            ];
        }
    }

    protected $listeners = ['quillUpdated' => 'updateQuillField'];

    public function updateQuillField($data)
    {
        data_set($this, $data['field'], $data['value']);
    }

    public function render()
    {
        $categories = TourCategory::all();
        $tags = \App\Models\Tag::all(); // Load all tags
        $locations = Location::orderBy('name')->with('hotels')->get(); // Load locations with hotels

        return view('livewire.tours.tour-create-component', [
            'categories' => $categories,
            'tags' => $tags,
            'locations' => $locations,
        ]);
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value, language: 'ru');
        // Автозаполнение SEO заголовка если он пуст
        if (empty($this->seo_title)) {
            $this->seo_title = $value;
        }
    }

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

    public function addInclusion()
    {
        $this->inclusions[] = [
            'inclusion_id' => '',
            'is_included' => 1 // Default to included
        ];
    }

    public function removeInclusion($index)
    {
        unset($this->inclusions[$index]);
        $this->inclusions = array_values($this->inclusions);
    }

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

    // === Методы для AI-перевода ===

    /**
     * Автоперевод на английский через Gemini AI
     */
    public function autoTranslateToEnglish(GeminiTranslationService $translator)
    {
        $fallbackLocale = config('app.fallback_locale');

        // Sync main title to trans array ensuring it's not empty for translation
        if (!empty($this->title)) {
            $this->trans[$fallbackLocale]['title'] = $this->title;
        }

        if (empty($this->trans[$fallbackLocale]['title'])) {
            LivewireAlert::title('Ошибка')
                ->text('Заполните русскую версию перед переводом.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }

        // 1. Перевод основных полей
        $translations = $translator->translateFields([
            'title' => $this->trans[$fallbackLocale]['title'],
            'short_description' => $this->trans[$fallbackLocale]['short_description'] ?? '',
        ], 'English', 'Тур');

        if ($translations['title']) {
            $this->trans['en']['title'] = $translations['title'];
            $this->trans['en']['short_description'] = $translations['short_description'] ?? '';
            $this->dispatch('refresh-quill');

            LivewireAlert::title('Перевод выполнен')
                ->text('Перевод на английский успешно выполнен!')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        } else {
            LivewireAlert::title('Ошибка')
                ->text('Не удалось получить перевод. Проверьте логи.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
        }

        // 2. Перевод дней программы
        foreach ($this->itinerary_days as $index => $day) {
            $dayTitle = $day['trans'][$fallbackLocale]['title'] ?? '';
            $dayDesc = $day['trans'][$fallbackLocale]['description'] ?? '';

            if ($dayTitle || $dayDesc) {
                $dayTrans = $translator->translateFields([
                    'title' => $dayTitle,
                    'description' => $dayDesc,
                ], 'English', 'День тура');

                $this->itinerary_days[$index]['trans']['en']['title'] = $dayTrans['title'] ?? '';
                $this->itinerary_days[$index]['trans']['en']['description'] = $dayTrans['description'] ?? '';
            }
        }

    }

    /**
     * Автоперевод на корейский через Gemini AI
     */
    public function autoTranslateToKorean(GeminiTranslationService $translator)
    {
        $fallbackLocale = config('app.fallback_locale');

        // Sync main title
        if (!empty($this->title)) {
            $this->trans[$fallbackLocale]['title'] = $this->title;
        }

        if (empty($this->trans[$fallbackLocale]['title'])) {
            LivewireAlert::title('Ошибка')
                ->text('Заполните русскую версию перед переводом.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }

        // 1. Перевод основных полей
        $translations = $translator->translateFields([
            'title' => $this->trans[$fallbackLocale]['title'],
            'short_description' => $this->trans[$fallbackLocale]['short_description'] ?? '',
        ], 'Korean', 'Тур');

        if ($translations['title']) {
            $this->trans['ko']['title'] = $translations['title'];
            $this->trans['ko']['short_description'] = $translations['short_description'] ?? '';
            $this->dispatch('refresh-quill');

            LivewireAlert::title('Перевод выполнен')
                ->text('Перевод на корейский успешно выполнен!')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        } else {
            LivewireAlert::title('Ошибка')
                ->text('Не удалось получить перевод. Проверьте логи.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
        }

        // 2. Перевод дней программы
        foreach ($this->itinerary_days as $index => $day) {
            $dayTitle = $day['trans'][$fallbackLocale]['title'] ?? '';
            $dayDesc = $day['trans'][$fallbackLocale]['description'] ?? '';

            if ($dayTitle || $dayDesc) {
                $dayTrans = $translator->translateFields([
                    'title' => $dayTitle,
                    'description' => $dayDesc,
                ], 'Korean', 'День тура');

                $this->itinerary_days[$index]['trans']['ko']['title'] = $dayTrans['title'] ?? '';
                $this->itinerary_days[$index]['trans']['ko']['description'] = $dayTrans['description'] ?? '';
            }
        }

    }

    /**
     * Автоперевод на все языки сразу
     */
    public function translateToAllLanguages(GeminiTranslationService $translator)
    {
        $fallbackLocale = config('app.fallback_locale');

        // Sync main title
        if (!empty($this->title)) {
            $this->trans[$fallbackLocale]['title'] = $this->title;
        }

        if (empty($this->trans[$fallbackLocale]['title'])) {
            LivewireAlert::title('Ошибка')
                ->text('Заполните русскую версию перед переводом.')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }

        // --- English ---
        // 1. Main fields
        $enTranslations = $translator->translateFields([
            'title' => $this->trans[$fallbackLocale]['title'],
            'short_description' => $this->trans[$fallbackLocale]['short_description'] ?? '',
        ], 'English', 'Тур');

        if (isset($enTranslations['title'])) {
            $this->trans['en']['title'] = $enTranslations['title'];
            $this->trans['en']['short_description'] = $enTranslations['short_description'] ?? '';
        }

        // 2. Itinerary
        foreach ($this->itinerary_days as $index => $day) {
            $dayTitle = $day['trans'][$fallbackLocale]['title'] ?? '';
            $dayDesc = $day['trans'][$fallbackLocale]['description'] ?? '';
            if ($dayTitle || $dayDesc) {
                $dayTrans = $translator->translateFields([
                    'title' => $dayTitle,
                    'description' => $dayDesc,
                ], 'English', 'День тура');
                $this->itinerary_days[$index]['trans']['en']['title'] = $dayTrans['title'] ?? '';
                $this->itinerary_days[$index]['trans']['en']['description'] = $dayTrans['description'] ?? '';
            }
        }

        // --- Korean ---
        // 1. Main fields
        $koTranslations = $translator->translateFields([
            'title' => $this->trans[$fallbackLocale]['title'],
            'short_description' => $this->trans[$fallbackLocale]['short_description'] ?? '',
        ], 'Korean', 'Тур');

        if (isset($koTranslations['title'])) {
            $this->trans['ko']['title'] = $koTranslations['title'];
            $this->trans['ko']['short_description'] = $koTranslations['short_description'] ?? '';
        }
        $this->dispatch('refresh-quill');

        // 2. Itinerary
        foreach ($this->itinerary_days as $index => $day) {
            $dayTitle = $day['trans'][$fallbackLocale]['title'] ?? '';
            $dayDesc = $day['trans'][$fallbackLocale]['description'] ?? '';
            if ($dayTitle || $dayDesc) {
                $dayTrans = $translator->translateFields([
                    'title' => $dayTitle,
                    'description' => $dayDesc,
                ], 'Korean', 'День тура');
                $this->itinerary_days[$index]['trans']['ko']['title'] = $dayTrans['title'] ?? '';
                $this->itinerary_days[$index]['trans']['ko']['description'] = $dayTrans['description'] ?? '';
            }
        }

        LivewireAlert::title('Перевод выполнен')
            ->text('Переводы на все языки успешно выполнены!')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function save()
    {
        $fallback = config('app.fallback_locale');
        $this->trans[$fallback]['title'] = $this->title;

        $this->validate();

        $tour = Tour::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'is_published' => $this->is_published,
            'base_price_cents' => $this->base_price_cents ?? 0,
            'duration_days' => $this->duration_days ?? 1,
            'short_description' => $this->trans[config('app.fallback_locale')]['short_description'] ?? '',
        ]);

        // Сохранение SEO
        if ($this->seo_title || $this->seo_description) {
            $tour->seo()->create([
                'title' => $this->seo_title,
                'description' => $this->seo_description,
            ]);
        }

        $fallbackLocale = config('app.fallback_locale');
        $this->trans[$fallbackLocale]['title'] = $this->title;

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                // Пропускаем пустые значения - не сохраняем переводы без перевода
                if ($value !== null && $value !== '') {
                    $tour->setTr($field, $locale, $value);
                }
            }
        }

        $tour->categories()->sync($this->category_id);

        // Process Tags
        if ($this->tags_selected) {
            $tour->tags()->sync($this->tags_selected);
        }

        foreach ($this->itinerary_days as $dayData) {
            $fallbackLocale = config('app.fallback_locale');
            $day = TourItineraryDay::create([
                'tour_id' => $tour->id,
                'day_number' => $dayData['day_number'],
                'title' => $dayData['trans'][$fallbackLocale]['title'] ?? '',
                'description' => $dayData['trans'][$fallbackLocale]['description'] ?? '',
            ]);

            foreach ($dayData['trans'] as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    // Пропускаем пустые значения
                    if ($value !== null && $value !== '') {
                        $day->setTr($field, $locale, $value);
                    }
                }
            }
        }

        // Sync Inclusions
        $syncData = [];
        foreach ($this->inclusions as $incData) {
            if (!empty($incData['inclusion_id'])) {
                $syncData[$incData['inclusion_id']] = ['is_included' => $incData['is_included']];
            }
        }
        $tour->inclusions()->sync($syncData);

        foreach ($this->accommodations as $accData) {
            TourAccommodation::create([
                'tour_id' => $tour->id,
                'nights_count' => $accData['nights_count'],
                'location_id' => $accData['location_id'] ?? null,
                'hotel_standard_id' => $accData['hotel_standard_id'] ?? null,
                'hotel_comfort_id' => $accData['hotel_comfort_id'] ?? null,
            ]);
        }

        if ($this->images && count($this->images) > 0) {
            $imageService = new ImageService();
            foreach ($this->images as $idx => $file) {
                $optimized = $imageService->saveOptimized($file, 'tours/' . $tour->id);

                Media::create([
                    'model_type' => Tour::class,
                    'model_id' => $tour->id,
                    'file_path' => $optimized['path'],
                    'file_name' => $optimized['file_name'],
                    'mime_type' => $optimized['mime_type'],
                    'size' => $optimized['size'],
                    'order' => $idx,
                ]);
            }
        }

        session()->flash('saved', [
            'title' => 'Тур создан!',
            'text' => 'Создан новый тур!',
        ]);
        return redirect()->route('admin.tours.index');
    }
}

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
    public $base_price; // Changed from base_price_cents
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

    public $last_translation_duration;

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
            'base_price' => 'nullable|numeric|min:0',
            'duration_days' => 'nullable|integer|min:0',

            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',

            'itinerary_days.*.day_number' => 'required|integer|min:1',
            'itinerary_days.*.location_id' => 'nullable|exists:locations,id',
            'itinerary_days.*.place_ids' => 'nullable|array',
            'itinerary_days.*.place_ids.*' => 'exists:places,id',
            'itinerary_days.*.hotel_ids' => 'nullable|array',
            'itinerary_days.*.hotel_ids.*' => 'exists:hotels,id',

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
        $rules['accommodations.*.hotel_standard_ids'] = 'nullable|array';
        $rules['accommodations.*.hotel_standard_ids.*'] = 'exists:hotels,id';
        $rules['accommodations.*.hotel_comfort_ids'] = 'nullable|array';
        $rules['accommodations.*.hotel_comfort_ids.*'] = 'exists:hotels,id';

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

    public function attributes(): array
    {
        $attributes = [
            'title' => 'Название',
            'slug' => 'Slug',
            'category_id' => 'Категория',
            'is_published' => 'Опубликовано',
            'base_price' => 'Цена',
            'duration_days' => 'Длительность',
            'images' => 'Изображения',
            'images.*' => 'Изображение',
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

    public function render()
    {
        $categories = TourCategory::all();
        $tags = \App\Models\Tag::all();

        // 1. Lightweight locations list for dropdowns (ID + Name only)
        $locations = Location::orderBy('name')->select('id', 'name')->get();

        // 2. Identify WHICH locations need full data (Hotels + Places)
        // Collect IDs from itinerary days
        $paramsLocIds = collect($this->itinerary_days)->pluck('location_id')->filter();

        // Collect IDs from accommodations
        $accLocIds = collect($this->accommodations)->pluck('location_id')->filter();

        $allSelectedIds = $paramsLocIds->merge($accLocIds)->unique()->values();

        // 3. Load heavy data ONLY for selected locations
        $selectedLocations = Location::whereIn('id', $allSelectedIds)
            ->with(['hotels', 'places'])
            ->get()
            ->keyBy('id'); // Key by ID for easy access in Blade

        return view('livewire.tours.tour-create-component', [
            'categories' => $categories,
            'tags' => $tags,
            'locations' => $locations,
            'selectedLocations' => $selectedLocations,
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

    public function updated($property, $value)
    {
        // When location changes in itinerary, clear selected places and hotels
        if (Str::startsWith($property, 'itinerary_days') && Str::endsWith($property, 'location_id')) {
            $parts = explode('.', $property);
            // parts: [itinerary_days, index, location_id]
            if (isset($parts[1])) {
                $index = $parts[1];
                $this->itinerary_days[$index]['place_ids'] = [];
                $this->itinerary_days[$index]['hotel_ids'] = [];
            }
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
            'hotel_standard_ids' => [],
            'hotel_comfort_ids' => [],
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
        if (!empty($this->short_description)) {
            $this->trans[$fallbackLocale]['short_description'] = $this->short_description;
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

            // Use unique keys
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
            if ($targetLangCode === config('app.fallback_locale')) {
                $this->short_description = $translated['main_desc'];
            }
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

    public function save(\App\Actions\Tour\CreateTourAction $createTourAction)
    {
        $fallback = config('app.fallback_locale');
        $this->trans[$fallback]['title'] = $this->title;

        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'is_published' => $this->is_published,
            'base_price' => $this->base_price,
            'duration_days' => $this->duration_days,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
        ];

        $createTourAction->execute(
            data: $data,
            images: $this->images,
            trans: $this->trans,
            itineraryDays: $this->itinerary_days,
            inclusions: $this->inclusions,
            accommodations: $this->accommodations,
            categories: $this->category_id,
            tags: $this->tags_selected
        );

        session()->flash('saved', [
            'title' => 'Тур создан!',
            'text' => 'Создан новый тур!',
        ]);

        // Отправка уведомления администраторам
        try {
            $admins = \App\Models\User::where('role', \App\Models\User::ROLE_ADMIN)->get();
            $tour = \App\Models\Tour::where('slug', $this->slug)->first(); // Получаем созданный тур
            if ($tour) {
                \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\SystemNotification(
                    'Новый тур',
                    "Создан новый тур: {$this->title}",
                    route('admin.tours.edit', $tour->id),
                    'bx-map'
                ));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Ошибка отправки уведомления о создании тура: ' . $e->getMessage());
        }

        return redirect()->route('admin.tours.index');
    }
}

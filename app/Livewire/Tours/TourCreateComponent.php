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
use App\Models\TourItineraryDay;
use App\Models\Inclusion; // Changed from TourInclusion
use App\Models\TourAccommodation;

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
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.short_description"] = 'nullable|string';
        }

        foreach (config('app.available_locales') as $l) {
            $rules["itinerary_days.*.trans.$l.title"] = 'required|string|max:255';
            $rules["itinerary_days.*.trans.$l.description"] = 'nullable|string';
        }

        // Removed translation rules for inclusions as they are now managed separately

        foreach (config('app.available_locales') as $l) {
            $rules["accommodations.*.trans.$l.location"] = 'required|string|max:255';
            $rules["accommodations.*.trans.$l.standard_options"] = 'nullable|string';
            $rules["accommodations.*.trans.$l.comfort_options"] = 'nullable|string';
        }

        return $rules;
    }

    public function mount()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = '';
            $this->trans[$locale]['short_description'] = '';
        }

        $this->available_inclusions = Inclusion::all();
    }

    protected $listeners = ['quillUpdated' => 'updateQuillField'];

    public function updateQuillField($data)
    {
        data_set($this, $data['field'], $data['value']);
    }

    public function render()
    {
        $categories = TourCategory::all();
        return view('livewire.tours.tour-create-component', [
            'categories' => $categories,
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
        $trans = [];
        foreach (config('app.available_locales') as $locale) {
            $trans[$locale] = [
                'location' => '',
                'standard_options' => '',
                'comfort_options' => ''
            ];
        }

        $this->accommodations[] = [
            'nights_count' => 1,
            'trans' => $trans
        ];
    }

    public function removeAccommodation($index)
    {
        unset($this->accommodations[$index]);
        $this->accommodations = array_values($this->accommodations);
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
                $tour->setTr($field, $locale, $value);
            }
        }

        $tour->categories()->sync($this->category_id);

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
                    $day->setTr($field, $locale, $value);
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
            $fallbackLocale = config('app.fallback_locale');
            $accommodation = TourAccommodation::create([
                'tour_id' => $tour->id,
                'nights_count' => $accData['nights_count'],
                'location' => $accData['trans'][$fallbackLocale]['location'] ?? '',
                'standard_options' => $accData['trans'][$fallbackLocale]['standard_options'] ?? '',
                'comfort_options' => $accData['trans'][$fallbackLocale]['comfort_options'] ?? '',
            ]);

            foreach ($accData['trans'] as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    $accommodation->setTr($field, $locale, $value);
                }
            }
        }

        if ($this->images && count($this->images) > 0) {
            foreach ($this->images as $idx => $file) {
                $path = Storage::disk('public_uploads')->putFileAs(
                    'tours/' . $tour->id,
                    $file,
                    $file->hashName()
                );

                Media::create([
                    'model_type' => Tour::class,
                    'model_id' => $tour->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
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

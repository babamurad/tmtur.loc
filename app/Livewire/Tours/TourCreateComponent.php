<?php

namespace App\Livewire\Tours;


use App\Models\Tour;
use App\Models\TourCategory;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Media; // Если вы будете использовать отдельную таблицу для медиа
use Carbon\Carbon;
use App\Models\TourItineraryDay;
use App\Models\TourInclusion;
use App\Models\TourAccommodation;

class TourCreateComponent extends Component
{
    use WithFileUploads; // Добавляем трейт

    // Основные поля тура
    public $title;
    public $slug;
    public $category_id = [];
    public $short_description = ''; // Инициализируем пустой строкой
    public $images = []; // Массив для множественной загрузки
    public $is_published = true;
    public $base_price_cents;
    public $duration_days;

    // Поля для итинерария (массив для хранения дней)
    public $itinerary_days = [];

    // Поля для включений (массив для хранения включений/невключений)
    public $inclusions = [];

    // Поля для аккомодаций (массив для хранения вариантов)
    public $accommodations = [];

    /* мультиязычные значения */
    public array $trans = [];   // [ru][title], [en][title] …

    protected function rules()
    {
        $rules = [
            // Правила для основного тура
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|min:3|max:255|unique:tours,slug',
            'short_description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'base_price_cents' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',

            // Правила для дней итинерария
            'itinerary_days.*.day_number' => 'required|integer|min:1',

            // Правила для включений/невключений
            'inclusions.*.type' => 'required|in:included,not_included',

            // Правила для аккомодаций
            'accommodations.*.nights_count' => 'required|integer|min:1',

            'category_id' => 'required|array|min:1',
            'category_id.*' => 'integer|exists:tour_categories,id',
        ];

        /* переводы для основного тура */
        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.short_description"] = 'nullable|string';
        }

        /* переводы для дней итинерария */
        foreach (config('app.available_locales') as $l) {
            $rules["itinerary_days.*.trans.$l.title"] = 'required|string|max:255';
            $rules["itinerary_days.*.trans.$l.description"] = 'nullable|string';
        }

        /* переводы для включений */
        foreach (config('app.available_locales') as $l) {
            $rules["inclusions.*.trans.$l.item"] = 'required|string';
        }

        /* переводы для размещения */
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
        $this->itinerary_days = array_values($this->itinerary_days); // Переиндексация
    }

    public function addInclusion()
    {
        $trans = [];
        foreach (config('app.available_locales') as $locale) {
            $trans[$locale] = [
                'item' => ''
            ];
        }
        
        $this->inclusions[] = [
            'type' => 'included',
            'trans' => $trans
        ];
    }

    public function removeInclusion($index)
    {
        unset($this->inclusions[$index]);
        $this->inclusions = array_values($this->inclusions); // Переиндексация
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
        $this->accommodations = array_values($this->accommodations); // Переиндексация
    }

    public function save()
    {
        $fallback = config('app.fallback_locale');
        $this->trans[$fallback]['title'] = $this->title; // ✅ синхронизация

        $this->validate();

        // Создаем основной тур
        $tour = Tour::create([
            'title' => $this->title,
            'slug' => $this->slug,

            'is_published' => $this->is_published,
            'base_price_cents' => $this->base_price_cents ?? 0,
            'duration_days' => $this->duration_days ?? 1,
            'short_description' => $this->trans[config('app.fallback_locale')]['short_description'] ?? '',
        ]);

        // сохраняем переводы
        $fallbackLocale = config('app.fallback_locale');
        $this->trans[$fallbackLocale]['title'] = $this->title;

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $tour->setTr($field, $locale, $value);
            }
        }

        // ПРИКРЕПЛЯЕМ КАТЕГОРИИ
        // Метод sync() удобен для "многие ко многим"
        $tour->categories()->sync($this->category_id);

        // Создаем связанные дни итинерария
        foreach ($this->itinerary_days as $dayData) {
            $fallbackLocale = config('app.fallback_locale');
            $day = TourItineraryDay::create([
                'tour_id' => $tour->id,
                'day_number' => $dayData['day_number'],
                'title' => $dayData['trans'][$fallbackLocale]['title'] ?? '',
                'description' => $dayData['trans'][$fallbackLocale]['description'] ?? '',
            ]);
            
            // Сохраняем переводы
            foreach ($dayData['trans'] as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    $day->setTr($field, $locale, $value);
                }
            }
        }

        // Создаем связанные включения/невключения
        foreach ($this->inclusions as $incData) {
            $fallbackLocale = config('app.fallback_locale');
            $inclusion = TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => $incData['type'],
                'item' => $incData['trans'][$fallbackLocale]['item'] ?? '',
            ]);
            
            // Сохраняем переводы
            foreach ($incData['trans'] as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    $inclusion->setTr($field, $locale, $value);
                }
            }
        }

        // Создаем связанные аккомодации
        foreach ($this->accommodations as $accData) {
            $fallbackLocale = config('app.fallback_locale');
            $accommodation = TourAccommodation::create([
                'tour_id' => $tour->id,
                'nights_count' => $accData['nights_count'],
                'location' => $accData['trans'][$fallbackLocale]['location'] ?? '',
                'standard_options' => $accData['trans'][$fallbackLocale]['standard_options'] ?? '',
                'comfort_options' => $accData['trans'][$fallbackLocale]['comfort_options'] ?? '',
            ]);
            
            // Сохраняем переводы
            foreach ($accData['trans'] as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    $accommodation->setTr($field, $locale, $value);
                }
            }
        }

        // Сохранение изображений (множественная загрузка)
        if ($this->images && count($this->images) > 0) {
            foreach ($this->images as $idx => $file) {
                $path = Storage::disk('public_uploads')->putFileAs(
                    'tours/' . $tour->id,
                    $file,
                    $file->hashName()
                );

                Media::create([
                    'model_type' => Tour::class,
                    'model_id'   => $tour->id,
                    'file_path'  => $path,
                    'file_name'  => $file->getClientOriginalName(),
                    'mime_type'  => $file->getClientMimeType(),
                    'order'      => $idx, // Порядок загрузки
                ]);
            }
        }

        session()->flash('saved', [
            'title' => 'Тур создан!',
            'text' => 'Создан новый тур!',
        ]);
        return redirect()->route('tours.index');
    }
}

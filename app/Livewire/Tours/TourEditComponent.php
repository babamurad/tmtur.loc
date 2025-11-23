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
use App\Models\TourItineraryDay;
use App\Models\TourInclusion;
use App\Models\TourAccommodation;

class TourEditComponent extends Component
{
    use WithFileUploads;

    public Tour $tour;

    /* Основные поля */
    public string $title          = '';
    public ?string $slug          = null;
    public array $category_id      = [];
    public bool $is_published     = true;
    public ?int $base_price_cents = null;
    public ?int $duration_days    = null;


    /* Изображение */
    public $newimage = null;   // временное новое изображение
    public $image    = null;   // текущее сохранённое

    /* Динамические массивы */
    public array $itinerary_days  = [];
    public array $inclusions      = [];
    public array $accommodations  = [];
    /* мультиязычные значения */
    public array $trans = [];   // [ru][title], [en][title] …

    /* Правила */
    protected function rules(): array
    {
        $rules = [
            'title'                => 'required|min:3|max:255',
            'slug'                 => 'nullable|min:3|max:255|unique:tours,slug,'.$this->tour->id,
            'category_id'          => 'required|array|min:1',
            'category_id.*'        => 'integer|exists:tour_categories,id',
            'is_published'         => 'boolean',
            'base_price_cents'     => 'required|integer|min:0',
            'duration_days'        => 'required|integer|min:1',
            'newimage'             => 'nullable|image|max:2048',

            'itinerary_days'              => 'nullable|array',
            'itinerary_days.*.day_number' => 'required|integer|min:1',

            'inclusions'                  => 'nullable|array',
            'inclusions.*.type'           => 'required|in:included,not_included',

            'accommodations'              => 'nullable|array',
            'accommodations.*.nights_count' => 'required|integer|min:1',
        ];

        /* переводы для основного тура */
        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"]       = 'nullable|string|max:255';
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

    protected $listeners = ['quillUpdated' => 'updateQuillField'];

    public function updateQuillField($data)
    {
        data_set($this, $data['field'], $data['value']);
    }


    public function mount(int $id)
    {
        $tour = Tour::findOrFail($id);
        $this->tour = $tour;

        $this->title             = $tour->title;
        $this->slug              = $tour->slug;
        $this->is_published      = $tour->is_published;
        $this->base_price_cents  = $tour->base_price_cents;
        $this->duration_days     = $tour->duration_days;

        $this->category_id = $tour->categories->pluck('id')->toArray();
        $this->image = $tour->media ? asset('uploads/'.$tour->media->file_path) : null;

        // Загружаем дни итинерария с переводами
        $this->itinerary_days = $tour->itineraryDays->map(function($item) {
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

        // Загружаем включения с переводами
        $this->inclusions = $tour->inclusions->map(function($item) {
            $trans = [];
            foreach (config('app.available_locales') as $locale) {
                $trans[$locale] = [
                    'item' => $item->tr('item', $locale),
                ];
            }
            return [
                'id' => $item->id,
                'type' => $item->type,
                'trans' => $trans
            ];
        })->all();

        // Загружаем размещение с переводами
        $this->accommodations = $tour->accommodations->map(function($item) {
            $trans = [];
            foreach (config('app.available_locales') as $locale) {
                $trans[$locale] = [
                    'location' => $item->tr('location', $locale),
                    'standard_options' => $item->tr('standard_options', $locale),
                    'comfort_options' => $item->tr('comfort_options', $locale),
                ];
            }
            return [
                'id' => $item->id,
                'nights_count' => $item->nights_count,
                'trans' => $trans
            ];
        })->all();

        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title']       = $this->tour->tr('title', $locale);
            $this->trans[$locale]['short_description'] = $this->tour->tr('short_description', $locale);
        }
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
        $this->inclusions = array_values($this->inclusions);
    }

    // === Методы для Accommodations ===
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

        // 1. только технические / не-переводимые поля
        // обновляем оригинал значением fallback-языка
        $fallbackLocale = config('app.fallback_locale');
        $this->tour->update([
            'title'             => $this->trans[$fallbackLocale]['title'],
            'short_description' => $this->trans[$fallbackLocale]['short_description'] ?? '',
            'is_published'      => $this->is_published,
            'base_price_cents'  => $this->base_price_cents,
            'duration_days'     => $this->duration_days,
        ]);

        // сохраняем переводы (включая fallback – на всякий случай)
        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $this->tour->setTr($field, $locale, $value);
            }
        }

        // 3. сброс кэша
        $this->tour->flushTrCache();

        $this->tour->categories()->sync($this->category_id);

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
                    $day->setTr($field, $locale, $value);
                }
            }
            
            $keepDays[] = $day->id;
        }
        TourItineraryDay::where('tour_id', $this->tour->id)
            ->whereNotIn('id', $keepDays)->delete();

        // Inclusions
        $keepInc = [];
        foreach ($this->inclusions as $incData) {
            $fallbackLocale = config('app.fallback_locale');
            $inc = TourInclusion::updateOrCreate(
                ['id' => $incData['id'] ?? null, 'tour_id' => $this->tour->id],
                [
                    'type' => $incData['type'],
                    'item' => $incData['trans'][$fallbackLocale]['item'] ?? '',
                ]
            );
            
            // Сохраняем переводы
            foreach ($incData['trans'] as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    $inc->setTr($field, $locale, $value);
                }
            }
            
            $keepInc[] = $inc->id;
        }
        TourInclusion::where('tour_id', $this->tour->id)
            ->whereNotIn('id', $keepInc)->delete();

        // Accommodations
        $keepAcc = [];
        foreach ($this->accommodations as $a) {
            $fallbackLocale = config('app.fallback_locale');
            $acc = TourAccommodation::updateOrCreate(
                ['id' => $a['id'] ?? null, 'tour_id' => $this->tour->id],
                [
                    'nights_count'     => $a['nights_count'],
                    'location'         => $a['trans'][$fallbackLocale]['location'] ?? '',
                    'standard_options' => $a['trans'][$fallbackLocale]['standard_options'] ?? '',
                    'comfort_options'  => $a['trans'][$fallbackLocale]['comfort_options'] ?? '',
                ]
            );
            
            // Сохраняем переводы
            foreach ($a['trans'] as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    $acc->setTr($field, $locale, $value);
                }
            }
            
            $keepAcc[] = $acc->id;
        }
        TourAccommodation::where('tour_id', $this->tour->id)
            ->whereNotIn('id', $keepAcc)->delete();

        // Image
        if ($this->newimage) {
            if ($old = $this->tour->media) {
                Storage::disk('public_uploads')->delete($old->file_path);
                $old->delete();
            }

            $path = Storage::disk('public_uploads')
                ->putFileAs('tours', $this->newimage,
                    Carbon::now()->timestamp.'.'.$this->newimage->extension());

            Media::create([
                'model_type' => Tour::class,
                'model_id'   => $this->tour->id,
                'file_path'  => $path,
                'file_name'  => $this->newimage->getClientOriginalName(),
                'mime_type'  => $this->newimage->getClientMimeType(),
            ]);
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
            'text'  => 'Все изменения сохранены.',
        ]);

        return redirect()->route('tours.index');
    }

    public function render()
    {
        $categories = TourCategory::select('id', 'title')->get();

        return view('livewire.tours.tour-edit-component', [
            'categories' => $categories,
        ]);
    }
}

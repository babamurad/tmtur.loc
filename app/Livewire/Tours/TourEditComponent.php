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
    public string $short_description = '';

    /* Изображение */
    public $newimage = null;   // временное новое изображение
    public $image    = null;   // текущее сохранённое

    /* Динамические массивы */
    public array $itinerary_days  = [];
    public array $inclusions      = [];
    public array $accommodations  = [];

    /* Правила */
    protected function rules(): array
    {
        return [
            'title'                => 'required|min:3|max:255',
            'slug'                 => 'nullable|min:3|max:255|unique:tours,slug,'.$this->tour->id,
            'category_id'          => 'required|array|min:1',
            'category_id.*'        => 'integer|exists:tour_categories,id',
            'is_published'         => 'boolean',
            'base_price_cents'     => 'required|integer|min:0',
            'duration_days'        => 'required|integer|min:1',
            'short_description'    => 'nullable|string',
            'newimage'             => 'nullable|image|max:2048',

            'itinerary_days'              => 'nullable|array',
            'itinerary_days.*.title'      => 'required|string|max:255',
            'itinerary_days.*.description'=> 'nullable|string',

            'inclusions'                  => 'nullable|array',
            'inclusions.*.type'           => 'required|in:included,not_included',
            'inclusions.*.item'           => 'required|string',

            'accommodations'              => 'nullable|array',
            'accommodations.*.location'   => 'required|string|max:255',
            'accommodations.*.nights_count' => 'required|integer|min:1',
            'accommodations.*.standard_options' => 'nullable|string',
            'accommodations.*.comfort_options'  => 'nullable|string',
        ];
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
        $this->short_description = $tour->short_description ?? '';

        $this->category_id = $tour->categories->pluck('id')->toArray();
        $this->image = $tour->media ? asset('uploads/'.$tour->media->file_path) : null;

        $this->itinerary_days = $tour->itineraryDays->map(fn($item) => $item->toArray())->all();
        $this->inclusions = $tour->inclusions->map(fn($item) => $item->toArray())->all();
        $this->accommodations = $tour->accommodations->map(fn($item) => $item->toArray())->all();
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    // === Методы для Itinerary Days ===
    public function addItineraryDay()
    {
        $this->itinerary_days[] = [
            'day_number' => count($this->itinerary_days) + 1,
            'title' => '',
            'description' => ''
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
            'type' => 'included',
            'item' => ''
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
            'location' => '',
            'nights_count' => 1,
            'standard_options' => '',
            'comfort_options' => ''
        ];
    }

    public function removeAccommodation($index)
    {
        unset($this->accommodations[$index]);
        $this->accommodations = array_values($this->accommodations);
    }

    public function save()
    {
        $this->validate();

        $this->tour->update([
            'title'             => $this->title,
            'slug'              => $this->slug,
            'is_published'      => $this->is_published,
            'base_price_cents'  => $this->base_price_cents,
            'duration_days'     => $this->duration_days,
            'short_description' => $this->short_description,
        ]);

        $this->tour->categories()->sync($this->category_id);

        // Itinerary
        $keepDays = [];
        foreach ($this->itinerary_days as $dayData) {
            $day = TourItineraryDay::updateOrCreate(
                ['id' => $dayData['id'] ?? null, 'tour_id' => $this->tour->id],
                [
                    'day_number' => $dayData['day_number'],
                    'title' => $dayData['title'],
                    'description' => $dayData['description'],
                ]
            );
            $keepDays[] = $day->id;
        }
        TourItineraryDay::where('tour_id', $this->tour->id)
            ->whereNotIn('id', $keepDays)->delete();

        // Inclusions
        $keepInc = [];
        foreach ($this->inclusions as $incData) {
            $inc = TourInclusion::updateOrCreate(
                ['id' => $incData['id'] ?? null, 'tour_id' => $this->tour->id],
                [
                    'type' => $incData['type'],
                    'item' => $incData['item'],
                ]
            );
            $keepInc[] = $inc->id;
        }
        TourInclusion::where('tour_id', $this->tour->id)
            ->whereNotIn('id', $keepInc)->delete();

        // Accommodations
        $keepAcc = [];
        foreach ($this->accommodations as $a) {
            $acc = TourAccommodation::updateOrCreate(
                ['id' => $a['id'] ?? null, 'tour_id' => $this->tour->id],
                [
                    'location'         => $a['location'],
                    'nights_count'     => $a['nights_count'],
                    'standard_options' => $a['standard_options'],
                    'comfort_options'  => $a['comfort_options'],
                ]
            );
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
        logger('saveAndClose');
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

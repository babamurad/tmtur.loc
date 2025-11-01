<?php

namespace App\Livewire\Tours;

use App\Models\Tour;
use App\Models\TourCategory;
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
    public ?int $category_id      = null;
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
            'category_id'          => 'required|exists:tour_categories,id',
            'short_description'    => 'nullable|string',
            'newimage'             => 'nullable|image|max:2048',
            'is_published'         => 'boolean',
            'base_price_cents'     => 'nullable|integer|min:0',
            'duration_days'        => 'nullable|integer|min:0',

            'itinerary_days.*.id'               => 'nullable|exists:tour_itinerary_days,id',
            'itinerary_days.*.day_number'       => 'required|integer|min:1',
            'itinerary_days.*.title'            => 'required|string|max:255',
            'itinerary_days.*.description'      => 'required|string',

            'inclusions.*.id'                   => 'nullable|exists:tour_inclusions,id',
            'inclusions.*.type'                 => 'required|in:included,not_included',
            'inclusions.*.item'                 => 'required|string',

            'accommodations.*.id'               => 'nullable|exists:tour_accommodations,id',
            'accommodations.*.location'         => 'required|string|max:255',
            'accommodations.*.nights_count'     => 'required|integer|min:1',
            'accommodations.*.standard_options' => 'nullable|string',
            'accommodations.*.comfort_options'  => 'nullable|string',
        ];
    }

    /* Mount */
    public function mount(int $id): void
    {
        $this->tour = Tour::with([
            'category',
            'itineraryDays',
            'inclusions',
            'accommodations',
            'media'
        ])->findOrFail($id);

        /* Заполняем поля */
        $this->title              = $this->tour->title;
        $this->slug               = $this->tour->slug;
        $this->category_id        = $this->tour->tour_category_id;
        $this->is_published       = $this->tour->is_published;
        $this->base_price_cents   = $this->tour->base_price_cents;
        $this->duration_days      = $this->tour->duration_days;
        $this->short_description  = $this->tour->short_description;
        $this->image              = $this->tour->media?->file_path;

        /* Массивы */
        $this->itinerary_days  = $this->tour->itineraryDays->map(fn($d) => [
            'id'          => $d->id,
            'day_number'  => $d->day_number,
            'title'       => $d->title,
            'description' => $d->description,
        ])->sortBy('day_number')->values()->toArray();

        $this->inclusions = $this->tour->inclusions->map(fn($i) => [
            'id'   => $i->id,
            'type' => $i->type,
            'item' => $i->item,
        ])->toArray();

        $this->accommodations = $this->tour->accommodations->map(fn($a) => [
            'id'               => $a->id,
            'location'         => $a->location,
            'nights_count'     => $a->nights_count,
            'standard_options' => $a->standard_options,
            'comfort_options'  => $a->comfort_options,
        ])->toArray();
    }

    /* Render */
    public function render()
    {
        return view('livewire.tours.tour-edit-component', [
            'categories' => TourCategory::all(),
        ]);
    }

    /* Управление днями */
    public function addItineraryDay(): void
    {
        $this->itinerary_days[] = [
            'id'          => null,
            'day_number'  => count($this->itinerary_days) + 1,
            'title'       => '',
            'description' => '',
        ];
    }

    public function removeItineraryDay(int $idx): void
    {
        if (($this->itinerary_days[$idx]['id'] ?? null)) {
            $this->itinerary_days[$idx]['_delete'] = true;
        } else {
            unset($this->itinerary_days[$idx]);
            $this->itinerary_days = array_values($this->itinerary_days);
        }
    }

    /* Управление включениями */
    public function addInclusion(): void
    {
        $this->inclusions[] = ['id' => null, 'type' => 'included', 'item' => ''];
    }

    public function removeInclusion(int $idx): void
    {
        if (($this->inclusions[$idx]['id'] ?? null)) {
            $this->inclusions[$idx]['_delete'] = true;
        } else {
            unset($this->inclusions[$idx]);
            $this->inclusions = array_values($this->inclusions);
        }
    }

    /* Управление размещением */
    public function addAccommodation(): void
    {
        $this->accommodations[] = [
            'id'               => null,
            'location'         => '',
            'nights_count'     => 1,
            'standard_options' => '',
            'comfort_options'  => '',
        ];
    }

    public function removeAccommodation(int $idx): void
    {
        if (($this->accommodations[$idx]['id'] ?? null)) {
            $this->accommodations[$idx]['_delete'] = true;
        } else {
            unset($accommodations[$idx]);
            $this->accommodations = array_values($this->accommodations);
        }
    }

    /* Сохранение */
    public function save(): \Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
    {
        $this->validate();

        /* 1. Обновляем тур */
        $this->tour->update([
            'title'            => $this->title,
            'slug'             => $this->slug ?: Str::slug($this->title, 'ru'),
            'tour_category_id' => $this->category_id,
            'is_published'     => $this->is_published,
            'base_price_cents' => $this->base_price_cents,
            'duration_days'    => $this->duration_days,
            'short_description'=> $this->short_description,
        ]);

        /* 2. Itinerary days */
        $keepDays = [];
        foreach ($this->itinerary_days as $d) {
            if (($d['_delete'] ?? false)) {
                TourItineraryDay::destroy($d['id']);
                continue;
            }
            $day = TourItineraryDay::updateOrCreate(
                ['id' => $d['id'] ?? 0],
                [
                    'tour_id'     => $this->tour->id,
                    'day_number'  => $d['day_number'],
                    'title'       => $d['title'],
                    'description' => $d['description'],
                ]
            );
            $keepDays[] = $day->id;
        }
        TourItineraryDay::where('tour_id', $this->tour->id)
            ->whereNotIn('id', $keepDays)->delete();

        /* 3. Inclusions */
        $keepInc = [];
        foreach ($this->inclusions as $i) {
            if (($i['_delete'] ?? false)) {
                TourInclusion::destroy($i['id']);
                continue;
            }
            $inc = TourInclusion::updateOrCreate(
                ['id' => $i['id'] ?? 0],
                [
                    'tour_id' => $this->tour->id,
                    'type'    => $i['type'],
                    'item'    => $i['item'],
                ]
            );
            $keepInc[] = $inc->id;
        }
        TourInclusion::where('tour_id', $this->tour->id)
            ->whereNotIn('id', $keepInc)->delete();

        /* 4. Accommodations */
        $keepAcc = [];
        foreach ($this->accommodations as $a) {
            if (($a['_delete'] ?? false)) {
                TourAccommodation::destroy($a['id']);
                continue;
            }
            $acc = TourAccommodation::updateOrCreate(
                ['id' => $a['id'] ?? 0],
                [
                    'tour_id'          => $this->tour->id,
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

        /* 5. Изображение */
        if ($this->newimage) {
            /* удаляем старое */
            if ($old = $this->tour->media) {
                Storage::disk('public_uploads')->delete($old->file_path);
                $old->delete();
            }
            /* сохраняем новое */
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

        session()->flash('saved', [
            'title' => 'Тур обновлён!',
            'text'  => 'Все изменения сохранены.',
        ]);
        return redirect()->route('tours.index');
    }
}

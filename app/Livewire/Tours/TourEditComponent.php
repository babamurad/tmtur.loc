<?php

namespace App\Livewire\Tours;

use App\Models\Tour;
use App\Models\TourCategory;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads ;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TourEditComponent extends Component
{
    use WithFileUploads;

    public $tour;
    public $title;
    public $slug;
    public $category_id;
    public $is_published;
    public $base_price_cents;
    public $duration_days;
    public $newimage = null;
    public $image    = null;
    public $description;

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|min:3|max:255|unique:tours,slug,' . $this->tour->id,
            'category_id' => 'required|exists:tour_categories,id',
            'newimage' => 'nullable|image|max:2048',
            // 'is_published' => 'boolean',
            'base_price_cents' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',
            'description' => 'nullable'
        ];
    }

    public function mount($id)
    {
        $tour = Tour::with('tourCategory', 'media')->findOrFail($id);
        if (!$tour) {
            session()->flash('error', 'Тур не найден.');
            return redirect()->route('tours.index');
        }

        $this->tour = $tour;
        $this->title = $tour->title;
        $this->slug = $tour->slug;
        $this->category_id = $tour->tourCategory->id;
        $this->is_published = $tour->is_published;
        $this->base_price_cents = $tour->base_price_cents;
        $this->duration_days = $tour->duration_days;
        $this->description = $tour->description;
        if ( $tour->media ) {
            $this->image = $tour->media->file_path;
        }

    }

    public function render()
    {
        $categories = TourCategory::all();
        return view('livewire.tours.tour-edit-component', [
            'categories' => $categories,
        ]);
    }

    public function save()
    {
        $this->validate();

        // 1. обновляем собственные поля
        $this->tour->fill([
            'title'            => $this->title,
            'tour_category_id' => $this->category_id,
            'base_price_cents' => $this->base_price_cents,
            'duration_days'    => $this->duration_days,
        ])->save();

        // 2. картинка
        if ($this->newimage) {
            /* 1. Удаляем старый файл -------------------- */
            $old = $this->tour->media;          // Media модель
            if ($old && $old->file_path) {
                // удаляем именно с того диска, куда складываем новые файлы
                Storage::disk('public_uploads')->delete($old->file_path);
            }

            /* 2. Сохраняем новый файл ------------------ */
            $path = $this->newimage->store('tours', 'public_uploads'); // ← disk = public
            // $path = "tours/hfjd7wL7KjBQuCeW.jpg"

            $this->tour->media()->updateOrCreate(
                ['model_type' => Tour::class],
                [
                    'file_path' => $path,      // ← относительный путь
                    'file_name' => $this->newimage->getClientOriginalName(),
                    'mime_type' => $this->newimage->getMimeType(),
                ]
            );
        }

        session()->flash('saved', ['title' => 'Тур сохранён!', 'text' => 'Изменения сохранились!']);
        return redirect()->route('tours.index');
    }
}

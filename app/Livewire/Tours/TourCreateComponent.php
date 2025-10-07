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

class TourCreateComponent extends Component
{
    use WithFileUploads;
    
    public $tourId;
    public $title;
    public $slug;
    public $category_id;
    public $content;
    public $image = '';
    public $is_published = true;
    public $base_price_cents;
    public $duration_days;

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|min:3|max:255|unique:tours,slug',
            'category_id' => 'required|exists:tour_categories,id',
            'content' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'base_price_cents' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',
        ];
    }

    public function render()
    {
        $categories = TourCategory::all();
        return view('livewire.tours.tour-create-component', [
            'categories' => $categories,
        ]);
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title, language: 'ru');
    }

    public function save()
    {
        $this->validate();

        $imagePath = null;
        $imageName = null;
        if ($this->image) {
            $imageName = 'tours/' . Carbon::now()->timestamp . '.' . $this->image->extension();
            $imagePath = $this->image->storeAs($imageName);
        }

        Tour::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'tour_category_id' => $this->category_id,
            'content' => $this->content,            
            'is_published' => $this->is_published,
            'base_price_cents' => $this->base_price_cents,
            'duration_days' => $this->duration_days,
        ]);

        $this->tourId = Tour::latest()->first()->id;

        Media::create([
            'model_type' => Tour::class,
            'model_id' => $this->tourId,
            'file_path' => $imagePath,
            'file_name' => $this->image->getClientOriginalName(),
            'mime_type' => $this->image->getClientMimeType(),
        ]);

        session()->flash('saved', [
            'title' => 'Тур создан!',
            'text' => 'Создан новый тур!',
        ]);
        return redirect()->route('tours.index');
    }
}

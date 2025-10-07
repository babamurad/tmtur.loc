<?php

namespace App\Livewire\Tours;

use App\Models\Tour;
use App\Models\TourCategory;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class TourEditComponent extends Component
{
    use WithFileUploads;

    public $tour;
    public $title;
    public $slug;
    public $category_id;
    public $content;
    public $image;
    public $is_published;
    public $base_price_cents;
    public $duration_days;
    public $oldImage;

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|min:3|max:255|unique:tours,slug,' . $this->tour->id,
            'category_id' => 'required|exists:tour_categories,id',
            'content' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'base_price_cents' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',
        ];
    }

    public function mount(Tour $tour)
    {
        $this->tour = $tour;
        $this->title = $tour->title;
        $this->slug = $tour->slug;
        $this->category_id = $tour->tour_category_id;
        $this->content = $tour->content;
        $this->image = $tour->image;
        $this->is_published = $tour->is_published;
        $this->base_price_cents = $tour->base_price_cents;
        $this->duration_days = $tour->duration_days;
        $this->oldImage = $tour->image;
    }

    public function render()
    {
        $categories = TourCategory::all();
        return view('livewire.tours.tour-edit-component', [
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

        $imagePath = $this->oldImage;
        if ($this->image && is_object($this->image)) {
            if ($this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $imagePath = $this->image->store('tours', 'public');
        }

        $this->tour->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'tour_category_id' => $this->category_id,
            'content' => $this->content,
            'image' => $imagePath,
            'is_published' => $this->is_published,
            'base_price_cents' => $this->base_price_cents,
            'duration_days' => $this->duration_days,
        ]);

        session()->flash('saved', [
            'title' => 'Тур сохранен!',
            'text' => 'Изменения сохранились!',
        ]);
        return redirect()->route('tours.index');
    }
}

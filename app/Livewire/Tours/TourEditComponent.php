<?php

namespace App\Livewire\Tours;

use App\Models\Tour;
use App\Models\TourCategory;
use Livewire\Component;
use Illuminate\Support\Str;

class TourEditComponent extends Component
{
    public $tour;
    public $title;
    public $slug;
    public $category_id;
    public $content;
    public $image;
    public $is_published;

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|min:3|max:255|unique:tours,slug,' . $this->tour->id,
            'category_id' => 'required|exists:tour_categories,id',
            'content' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ];
    }

    public function mount(Tour $tour)
    {
        $this->tour = $tour;
        $this->title = $tour->title;
        $this->slug = $tour->slug;
        $this->category_id = $tour->category_id;
        $this->content = $tour->content;
        $this->image = $tour->image;
        $this->is_published = $tour->is_published;
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
        $this->slug = Str::slug($this->title);
    }

    public function save()
    {
        $this->validate();

        $this->tour->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
            'content' => $this->content,
            'image' => $this->image,
            'is_published' => $this->is_published,
        ]);

        session()->flash('saved', [
            'title' => 'Тур сохранен!',
            'text' => 'Изменения сохранились!',
        ]);
        return redirect()->route('tours.index');
    }
}

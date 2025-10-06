<?php

namespace App\Livewire\TourCategories;

use App\Models\TourCategory;
use Livewire\Component;
use Illuminate\Support\Str;

class TourCategoryEditComponent extends Component
{
    public $tourCategory;
    public $title;
    public $slug;
    public $content;
    public $image;
    public $is_published;

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|min:3|max:255|unique:tour_categories,slug,' . $this->tourCategory->id,
            'content' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ];
    }

    public function mount(TourCategory $tourCategory)
    {
        $this->tourCategory = $tourCategory;
        $this->title = $tourCategory->title;
        $this->slug = $tourCategory->slug;
        $this->content = $tourCategory->content;
        $this->image = $tourCategory->image;
        $this->is_published = $tourCategory->is_published;
    }

    public function render()
    {
        return view('livewire.tour-categories.tour-category-edit-component');
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    public function save()
    {
        $this->validate();

        $this->tourCategory->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'image' => $this->image,
            'is_published' => $this->is_published,
        ]);

        session()->flash('saved', [
            'title' => 'Категория тура сохранена!',
            'text' => 'Изменения сохранились!',
        ]);
        return redirect()->route('tour-categories.index');
    }
}
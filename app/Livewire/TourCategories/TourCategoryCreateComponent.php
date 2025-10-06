<?php

namespace App\Livewire\TourCategories;

use App\Models\TourCategory;
use Livewire\Component;
use Illuminate\Support\Str;

class TourCategoryCreateComponent extends Component
{
    public $title;
    public $slug;
    public $content;
    public $image;
    public $is_published = true;

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|min:3|max:255|unique:tour_categories,slug',
            'content' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ];
    }

    public function render()
    {
        return view('livewire.tour-categories.tour-category-create-component');
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->title);
    }

    public function save()
    {
        $this->validate();

        TourCategory::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'image' => $this->image,
            'is_published' => $this->is_published,
        ]);

        session()->flash('saved', [
            'title' => 'Категория тура создана!',
            'text' => 'Создана новая категория тура!',
        ]);
        return redirect()->route('tour-categories.index');
    }
}
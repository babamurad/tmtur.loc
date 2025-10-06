<?php

namespace App\Livewire\Tours;

use App\Models\Tour;
use App\Models\TourCategory;
use Livewire\Component;
use Illuminate\Support\Str;

class TourCreateComponent extends Component
{
    public $title;
    public $slug;
    public $category_id;
    public $content;
    public $image;
    public $is_published = true;

    protected function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'nullable|min:3|max:255|unique:tours,slug',
            'category_id' => 'required|exists:tour_categories,id',
            'content' => 'nullable',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
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
        $this->slug = Str::slug($this->title);
    }

    public function save()
    {
        $this->validate();

        Tour::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
            'content' => $this->content,
            'image' => $this->image,
            'is_published' => $this->is_published,
        ]);

        session()->flash('saved', [
            'title' => 'Тур создан!',
            'text' => 'Создан новый тур!',
        ]);
        return redirect()->route('tours.index');
    }
}

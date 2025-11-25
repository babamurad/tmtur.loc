<?php

namespace App\Livewire\Front;

use App\Models\Tour;
use App\Models\TourCategory;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryShowTour extends Component
{
    use WithPagination;

    public TourCategory $category;
    public string $view = 'grid';

    public function setView(string $view)
    {
        $this->view = $view;
    }

    public function mount(string $slug)
    {
        $this->category = TourCategory::whereSlug($slug)
            ->where('is_published', true)
            ->firstOrFail();
    }

    public function render()
    {
        $categories = TourCategory::where('is_published', true)->get();

        $tours = $this->category->tours()
            ->where('is_published', true)
            ->with(['media', 'groupsOpen'])
            ->paginate(4);

        return view('livewire.front.category-show-tour', [
            'categories' => $categories,
            'category' => $this->category,
            'tours' => $tours,
            'view' => $this->view,
        ])
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.category_tours', ['category' => $this->category->tr('title')]));
    }
}

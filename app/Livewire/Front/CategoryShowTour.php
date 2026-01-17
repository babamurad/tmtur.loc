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
    public array $selectedDurations = [];
    public array $availableDurations = [];

    public function setView(string $view)
    {
        $this->view = $view;
        session()->put('tour_view_preference', $view);
    }

    public function updatedSelectedDurations()
    {
        $this->resetPage();
    }

    public function mount(string $slug)
    {
        $this->view = session('tour_view_preference', 'grid');
        $this->category = TourCategory::whereSlug($slug)
            ->where('is_published', true)
            ->firstOrFail();

        $this->availableDurations = $this->category->tours()
            ->where('is_published', true)
            ->distinct()
            ->orderBy('duration_days')
            ->pluck('duration_days')
            ->toArray();
    }

    public function render()
    {
        $categories = TourCategory::where('is_published', true)->get();

        $tours = $this->category->tours()
            ->where('is_published', true)
            ->when(!empty($this->selectedDurations), function ($query) {
                $query->whereIn('duration_days', $this->selectedDurations);
            })
            ->with(['media', 'groupsOpen'])
            ->paginate(4);

        $catTitle = $this->category->tr('title');
        \Artesaos\SEOTools\Facades\SEOTools::setTitle($catTitle);
        \Artesaos\SEOTools\Facades\SEOTools::setDescription("Tours in category: $catTitle");
        \Artesaos\SEOTools\Facades\SEOTools::opengraph()->setUrl(route('tours.category.show', $this->category->slug));

        return view('livewire.front.category-show-tour', [
            'categories' => $categories,
            'category' => $this->category,
            'tours' => $tours,
            'view' => $this->view,
            'availableDurations' => $this->availableDurations,
        ])
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

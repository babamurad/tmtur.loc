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
    public int $perPage = 4;
    public array $perPageOptions = [4, 8, 12, 24, 48];
    public string $sort = 'duration_asc';
    public array $sortOptions = [
        'duration_asc' => '<i class="fa fa-sort-amount-asc"></i>',
        'duration_desc' => '<i class="fa fa-sort-amount-desc"></i>'
    ];

    public function setView(string $view)
    {
        $this->view = $view;
        session()->put('tour_view_preference', $view);
    }

    public function updatedSelectedDurations()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        session()->put('tour_per_page', $value);
        $this->resetPage();
    }

    public function updatedSort($value)
    {
        session()->put('tour_sort', $value);
        $this->resetPage();
    }

    public function mount(string $slug)
    {
        $this->view = session('tour_view_preference', 'grid');
        $this->perPage = session('tour_per_page', 4);
        $this->sort = session('tour_sort', 'duration_asc');
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
            ->when($this->sort === 'duration_asc', function ($query) {
                $query->orderBy('duration_days', 'asc');
            })
            ->when($this->sort === 'duration_desc', function ($query) {
                $query->orderBy('duration_days', 'desc');
            })
            ->with(['media', 'groupsOpen'])
            ->paginate($this->perPage);

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
            'perPageOptions' => $this->perPageOptions,
            'sortOptions' => $this->sortOptions,
        ])
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

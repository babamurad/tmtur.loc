<?php

namespace App\Livewire\Front;

use App\Models\Tour;
use App\Models\TourCategory;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public string $view = 'grid';
    public array $selectedDurations = [];
    public array $availableDurations = [];
    public int $perPage = 4;
    public array $perPageOptions = [4, 8, 12, 24, 48];
    public string $sort = 'duration_asc';
    public array $sortOptions = [
        'duration_asc' => '<i class="fa fa-sort-amount-desc"></i>',
        'duration_desc' => '<i class="fa fa-sort-amount-asc"></i>'
    ];

    public function mount()
    {
        $this->view = session('tour_view_preference', 'grid');
        $this->perPage = session('tour_per_page', 4);
        $this->sort = session('tour_sort', 'duration_asc');
        $this->availableDurations = Tour::where('is_published', true)
            ->distinct()
            ->orderBy('duration_days')
            ->pluck('duration_days')
            ->toArray();
    }

    public function updatingView()
    {
        $this->resetPage(); // СБРОСИТЬ пагинацию
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

    public function setView(string $view)
    {
        $this->resetPage(); // СБРОСИТЬ пагинацию
        $this->view = $view;
        session()->put('tour_view_preference', $view);
    }

    public function render()
    {
        $categories = TourCategory::all();
        $tours = Tour::where('is_published', true)
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

        return view('livewire.front.category-index', [
            'tours' => $tours,
            'categories' => $categories,
            'view' => $this->view,
            'availableDurations' => $this->availableDurations,
            'perPageOptions' => $this->perPageOptions,
            'sortOptions' => $this->sortOptions,
        ])
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.tours'));
    }
}

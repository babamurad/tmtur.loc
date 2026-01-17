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

    public function mount()
    {
        $this->view = session('tour_view_preference', 'grid');
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
            ->with(['media', 'groupsOpen'])
            ->paginate(4);

        return view('livewire.front.category-index', [
            'tours' => $tours,
            'categories' => $categories,
            'view' => $this->view,
            'availableDurations' => $this->availableDurations,
        ])
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.tours'));
    }
}

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

    public function setView(string $view)
    {
        $this->resetPage(); // СБРОСИТЬ пагинацию
        $this->view = $view;        
    }

    public function render()
    {
        $categories = TourCategory::all();
        $tours = Tour::where('is_published', true)
            ->with(['media', 'groupsOpen'])
            ->paginate(4);

        return view('livewire.front.category-index', [
            'tours' => $tours,
            'categories' => $categories,
            'view' => $this->view,
        ])
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.tours'));
    }
}

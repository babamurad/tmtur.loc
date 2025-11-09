<?php

namespace App\Livewire\Front;

use App\Models\Tour;
use App\Models\TourCategory;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $categories = TourCategory::all();
        $tours = Tour::where('is_published', true)->with('media')->paginate(4);
        return view('livewire.front.category-index', compact('tours', 'categories'))
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

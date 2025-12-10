<?php

namespace App\Livewire\Front;

use App\Models\Tour;
use App\Models\TourCategory;
use Livewire\Component;

class ToursSidebar extends Component
{
    public function render()
    {
        return view('livewire.front.tours-sidebar', [
            'categories' => TourCategory::withCount(['tours' => function ($query) {
                $query->where('is_published', true);
            }])->get(),
            'totalTours' => Tour::where('is_published', true)
                ->whereHas('categories')
                ->count(),
            // $tourGroupTotal = TourGroup::where    
        ])->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

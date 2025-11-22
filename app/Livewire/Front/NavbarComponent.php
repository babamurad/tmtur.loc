<?php

namespace App\Livewire\Front;

use App\Models\TourCategory;
use Livewire\Component;

class NavbarComponent extends Component
{
    public function render()
    {
         $categories = TourCategory::where('is_published', 1)->get();
         
        return view('livewire.front.navbar-component',
        ['categories' => $categories]
        )->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

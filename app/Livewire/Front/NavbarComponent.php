<?php

namespace App\Livewire\Front;

use App\Models\TourCategory;
use Livewire\Component;

class NavbarComponent extends Component
{
    public function render()
    {
         $categories = TourCategory::where('is_published', 1)->get();
        // $categories = Category::where('status', 1)->with('subCategories')->get();
        // $categories = Category::where('status', 1)->with('subCategories')->with('subCategories.subSubCategories')->get();
        // $categories = Category::where('status', 1)->with('subCategories.subSubCategories')->get();
        // $categories = Category::where('status', 1)->with('subCategories.subSubCategories')->with('subCategories.subSubCategories.subSubSubCategories')->get();
        return view('livewire.front.navbar-component',
        ['categories' => $categories]
        )->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

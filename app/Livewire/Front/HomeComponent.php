<?php

namespace App\Livewire\Front;

use App\Models\Guide;
use App\Models\Tour;
use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $tours = Tour::with('media')->orderBy('id', 'desc')->limit(3)->get();
        $fotos = \App\Models\TurkmenistanGallery::orderBy('order', 'desc')->get();
//        $guides = Guide::where('is_active', true)->orderBy('sort_order')->get();
        return view('livewire.front.home-component', compact('tours', 'fotos'))
            ->layout('layouts.front-app');
    }
}

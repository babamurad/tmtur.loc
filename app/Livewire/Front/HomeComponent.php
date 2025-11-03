<?php

namespace App\Livewire\Front;

use App\Models\Tour;
use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $tours = Tour::with('media')->orderBy('id', 'desc')->limit(3)->get();
        $fotos = \App\Models\TurkmenistanGallery::orderBy('order', 'desc')->get();
        return view('livewire.front.home-component', compact('tours', 'fotos'))
            ->layout('layouts.front-app');
    }
}

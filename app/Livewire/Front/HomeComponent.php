<?php

namespace App\Livewire\Front;

use App\Models\Guide;
use App\Models\Tour;
use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $tours = Tour::with('media', 'groupsOpen')->orderBy('id', 'desc')->limit(3)->get();
        $fotos = \App\Models\TurkmenistanGallery::where('is_featured', 1)->orderBy('order')->get();
//        $guides = Guide::where('is_active', true)->orderBy('sort_order')->get();
        return view('livewire.front.home-component', compact('tours', 'fotos'))
            ->layout('layouts.front-app')
            ->title(__('titles.home'));
    }
}

<?php

namespace App\Livewire\Front;

use App\Models\Tour;
use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $tours = Tour::with('media')->orderBy('id', 'desc')->limit(6)->get();
        return view('livewire.front.home-component', compact('tours'))
            ->layout('layouts.front-app');
    }
}

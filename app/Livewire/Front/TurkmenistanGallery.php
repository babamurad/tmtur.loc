<?php

namespace App\Livewire\Front;

use Livewire\Component;

class TurkmenistanGallery extends Component
{
    public function render()
    {
        return view('livewire.front.turkmenistan-gallery')
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.gallery'));
    }
}

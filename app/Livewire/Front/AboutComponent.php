<?php

namespace App\Livewire\Front;

use Livewire\Component;

class AboutComponent extends Component
{
    public function render()
    {
        return view('livewire.front.about-component')
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.about') ?? 'About Us');
    }
}

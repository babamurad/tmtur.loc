<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Artesaos\SEOTools\Facades\SEOTools;

class AboutComponent extends Component
{
    public function render()
    {
        SEOTools::setTitle(__('titles.about') ?? 'About Us');
        SEOTools::setDescription('Learn more about TMTourism, our mission and history.');
        SEOTools::opengraph()->setUrl(route('about'));

        return view('livewire.front.about-component')
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

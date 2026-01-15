<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\TurkmenistanGallery;

class ProductGallery extends Component
{
    public $images;
    // public $activeIndex = 0; // Removed, reusing modal logic only via JS

    public function mount()
    {
        $this->images = TurkmenistanGallery::all();
    }

    // setActive removed as it's not needed for the new layout

    public function render()
    {
        \Artesaos\SEOTools\Facades\SEOTools::setTitle(__('titles.gallery') ?? 'Gallery');
        \Artesaos\SEOTools\Facades\SEOTools::setDescription('Photo gallery of Turkmenistan.');
        \Artesaos\SEOTools\Facades\SEOTools::opengraph()->setUrl(route('gallery'));

        return view('livewire.front.product-gallery')
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\TurkmenistanGallery;

class ProductGallery extends Component
{
    public $images;
    public $activeIndex = 0;

    public function mount()
    {
        $this->images = TurkmenistanGallery::all();
    }

    public function setActive($index)   // было setActiveImage
    {
        $this->activeIndex = $index;
    }

    public function render()
    {
        \Artesaos\SEOTools\Facades\SEOTools::setTitle(__('titles.gallery') ?? 'Gallery');
        \Artesaos\SEOTools\Facades\SEOTools::setDescription('Photo gallery of Turkmenistan.');
        \Artesaos\SEOTools\Facades\SEOTools::opengraph()->setUrl(route('gallery'));

        return view('livewire.front.product-gallery')
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

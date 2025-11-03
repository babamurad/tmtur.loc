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
        return view('livewire.front.product-gallery')
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

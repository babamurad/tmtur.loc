<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\CarouselSlide;

class CarouselComponent extends Component
{
    public function render()
    {
        $carousels = CarouselSlide::where('is_active', true)->get();
        return view('livewire.front.carousel-component', [
            'carousels' => $carousels,
        ]);
    }
}

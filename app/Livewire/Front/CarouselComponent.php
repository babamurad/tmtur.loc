<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\CarouselSlide;

class CarouselComponent extends Component
{
    public function render()
    {
        $carousels = \Illuminate\Support\Facades\Cache::remember('home_carousel_slides', 86400, function () {
            return CarouselSlide::with('translations')->orderBy('id')->where('is_active', true)->get();
        });
        return view('livewire.front.carousel-component', [
            'carousels' => $carousels,
        ]);
    }
}

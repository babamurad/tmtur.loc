<?php

namespace App\Livewire\Front;

use Livewire\Component;

use Livewire\Attributes\Layout;

#[Layout('layouts.front-app', ['hideCarousel' => true])]
class Terms extends Component
{
    public function render()
    {
        return view('livewire.front.terms');
    }
}

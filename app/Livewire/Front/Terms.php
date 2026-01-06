<?php

namespace App\Livewire\Front;

use Livewire\Component;

use Livewire\Attributes\Layout;
use Artesaos\SEOTools\Facades\SEOTools;

#[Layout('layouts.front-app', ['hideCarousel' => true])]
class Terms extends Component
{
    public function mount()
    {
        SEOTools::setTitle(__('titles.terms'));
    }

    public function render()
    {
        return view('livewire.front.terms');
    }
}

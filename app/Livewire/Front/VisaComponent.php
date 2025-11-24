<?php

namespace App\Livewire\Front;

use Livewire\Component;

class VisaComponent extends Component
{
    public function render()
    {
        return view('livewire.front.visa-component')
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.visa'));
    }
}

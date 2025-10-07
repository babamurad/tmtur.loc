<?php

namespace App\Livewire\Front;

use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        return view('livewire.front.home-component')
            ->layout('layouts.front-app');
    }
}

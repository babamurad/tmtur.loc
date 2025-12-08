<?php

namespace App\Livewire\Front;

use Livewire\Component;

class TourGroupsIndexComponent extends Component
{
    public function render()
    {
        return view('livewire.front.tour-groups-index')
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.tours'));
    }
}


<?php

namespace App\Livewire\Front;

use App\Models\Tour;
use Livewire\Component;

class TourComponent extends Component
{
    public Tour $selectedTour;

    public function mount(string $id = null)
    {
        if ($id) {
//             dd($id);
            $this->selectedTour = Tour::find($id);
        } else {
            return;
        }
    }

    public function editTour($id)
    {
        if ($id) {
            $this->selectedTour = Tour::find($id);
        } else {
            return;
}

    }
    public function render()
    {
        $tours = Tour::with('tourCategory', 'media')->get();

        return view('livewire.front.tour-component', compact('tours'))
            ->layout('layouts.front-app');
    }
}

<?php

namespace App\Livewire\Admin\Place;

use App\Models\Place;
use App\Models\Location;
use App\Enums\PlaceType;
use Livewire\Component;
use Livewire\Attributes\Rule;

class PlaceCreateComponent extends Component
{
    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $type;

    #[Rule('nullable|numeric')]
    public $cost;

    #[Rule('required')]
    public $location_id;

    public function storePlace()
    {
        $this->validate();
        $place = new Place();
        $place->name = $this->name;
        $place->type = PlaceType::from($this->type);
        $place->cost = $this->cost;
        $place->location_id = $this->location_id;
        $place->save();
        session()->flash('message', 'Place has been created successfully!');
        return redirect()->route('admin.places.index');
    }

    public function render()
    {
        $locations = Location::all();
        $types = PlaceType::options();
        return view('livewire.admin.place.place-create-component', ['locations' => $locations, 'types' => $types])->layout('layouts.app');
    }
}

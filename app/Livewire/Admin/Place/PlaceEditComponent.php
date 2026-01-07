<?php

namespace App\Livewire\Admin\Place;

use App\Models\Place;
use App\Models\Location;
use App\Enums\PlaceType;
use Livewire\Component;
use Livewire\Attributes\Rule;

class PlaceEditComponent extends Component
{
    public $place_id;

    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $type;

    #[Rule('nullable|numeric')]
    public $cost;

    #[Rule('required')]
    public $location_id;

    public function mount($place_id)
    {
        $place = Place::find($place_id);
        $this->place_id = $place->id;
        $this->name = $place->name;
        $this->type = $place->type->value;
        $this->cost = $place->cost;
        $this->location_id = $place->location_id;
    }

    public function updatePlace()
    {
        $this->validate();
        $place = Place::find($this->place_id);
        $place->name = $this->name;
        $place->type = PlaceType::from($this->type);
        $place->cost = $this->cost;
        $place->location_id = $this->location_id;
        $place->save();
        session()->flash('message', 'Place has been updated successfully!');
        return redirect()->route('admin.places.index');
    }

    public function render()
    {
        $locations = Location::all();
        $types = PlaceType::options();
        return view('livewire.admin.place.place-edit-component', ['locations' => $locations, 'types' => $types])->layout('layouts.app');
    }
}

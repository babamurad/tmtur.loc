<?php

namespace App\Livewire\Admin\Location;

use App\Models\Location;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;

class LocationEditComponent extends Component
{
    public $location_id;

    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $slug;

    public $description;

    public function mount($location_id)
    {
        $location = Location::find($location_id);
        $this->location_id = $location->id;
        $this->name = $location->name;
        $this->slug = $location->slug;
        $this->description = $location->description;
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function updateLocation()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:locations,slug,' . $this->location_id
        ]);

        $location = Location::find($this->location_id);
        $location->name = $this->name;
        $location->slug = $this->slug;
        $location->description = $this->description;
        $location->save();
        session()->flash('message', 'Location has been updated successfully!');
        return redirect()->route('admin.locations.index');
    }

    public function render()
    {
        return view('livewire.admin.location.location-edit-component')->layout('layouts.app');
    }
}

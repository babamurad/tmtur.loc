<?php

namespace App\Livewire\Admin\Location;

use App\Models\Location;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;

class LocationCreateComponent extends Component
{
    #[Rule('required')]
    public $name;

    #[Rule('required|unique:locations')]
    public $slug;

    public $description;

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function storeLocation()
    {
        $this->validate();
        $location = new Location();
        $location->name = $this->name;
        $location->slug = $this->slug;
        $location->description = $this->description;
        $location->save();
        session()->flash('message', 'Location has been created successfully!');
        return redirect()->route('admin.locations.index');
    }

    public function render()
    {
        return view('livewire.admin.location.location-create-component')->layout('layouts.app');
    }
}

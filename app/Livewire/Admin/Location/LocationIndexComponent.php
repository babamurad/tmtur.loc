<?php

namespace App\Livewire\Admin\Location;

use App\Models\Location;
use Livewire\Component;
use Livewire\WithPagination;

class LocationIndexComponent extends Component
{
    use WithPagination;

    public function delete($id)
    {
        Location::find($id)->delete();
        session()->flash('message', 'Location has been deleted successfully!');
    }

    public function render()
    {
        $locations = Location::paginate(10);
        return view('livewire.admin.location.location-index-component', ['locations' => $locations])->layout('layouts.app');
    }
}

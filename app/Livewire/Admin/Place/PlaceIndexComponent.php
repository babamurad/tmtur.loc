<?php

namespace App\Livewire\Admin\Place;

use App\Models\Place;
use Livewire\Component;
use Livewire\WithPagination;

class PlaceIndexComponent extends Component
{
    use WithPagination;

    public function delete($id)
    {
        Place::find($id)->delete();
        session()->flash('message', 'Place has been deleted successfully!');
    }

    public function render()
    {
        $places = Place::paginate(10);
        return view('livewire.admin.place.place-index-component', ['places' => $places])->layout('layouts.app');
    }
}

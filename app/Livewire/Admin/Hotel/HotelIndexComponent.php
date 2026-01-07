<?php

namespace App\Livewire\Admin\Hotel;

use App\Models\Hotel;
use Livewire\Component;
use Livewire\WithPagination;

class HotelIndexComponent extends Component
{
    use WithPagination;

    public function delete($id)
    {
        Hotel::find($id)->delete();
        session()->flash('message', 'Hotel has been deleted successfully!');
    }

    public function render()
    {
        $hotels = Hotel::paginate(10);
        return view('livewire.admin.hotel.hotel-index-component', ['hotels' => $hotels])->layout('layouts.app');
    }
}

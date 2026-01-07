<?php

namespace App\Livewire\Admin\Hotel;

use App\Models\Hotel;
use App\Models\Location;
use App\Enums\HotelCategory;
use Livewire\Component;
use Livewire\Attributes\Rule;

class HotelCreateComponent extends Component
{
    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $category;

    #[Rule('required')]
    public $location_id;

    public function storeHotel()
    {
        $this->validate();
        $hotel = new Hotel();
        $hotel->name = $this->name;
        $hotel->category = HotelCategory::from($this->category);
        $hotel->location_id = $this->location_id;
        $hotel->save();
        session()->flash('message', 'Hotel has been created successfully!');
        return redirect()->route('admin.hotels.index');
    }

    public function render()
    {
        $locations = Location::all();
        $categories = HotelCategory::options();
        return view('livewire.admin.hotel.hotel-create-component', ['locations' => $locations, 'categories' => $categories])->layout('layouts.app');
    }
}

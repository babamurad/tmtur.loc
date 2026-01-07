<?php

namespace App\Livewire\Admin\Hotel;

use App\Models\Hotel;
use App\Models\Location;
use App\Enums\HotelCategory;
use Livewire\Component;
use Livewire\Attributes\Rule;

class HotelEditComponent extends Component
{
    public $hotel_id;

    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $category;

    #[Rule('required')]
    public $location_id;

    public function mount($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        $this->hotel_id = $hotel->id;
        $this->name = $hotel->name;
        $this->category = $hotel->category->value;
        $this->location_id = $hotel->location_id;
    }

    public function updateHotel()
    {
        $this->validate();
        $hotel = Hotel::find($this->hotel_id);
        $hotel->name = $this->name;
        $hotel->category = HotelCategory::from($this->category);
        $hotel->location_id = $this->location_id;
        $hotel->save();
        session()->flash('message', 'Hotel has been updated successfully!');
        return redirect()->route('admin.hotels.index');
    }

    public function render()
    {
        $locations = Location::all();
        $categories = HotelCategory::options();
        return view('livewire.admin.hotel.hotel-edit-component', ['locations' => $locations, 'categories' => $categories])->layout('layouts.app');
    }
}

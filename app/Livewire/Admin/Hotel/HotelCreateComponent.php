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
    public $location_id;

    #[Rule('required')]
    public $category;

    public array $trans = [];
    public $locations;
    public $categories;

    protected function rules()
    {
        $rules = [
            'name' => 'required',
            'location_id' => 'required|exists:locations,id',
            'category' => 'required',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.name"] = 'nullable|string|max:255';
        }

        return $rules;
    }

    public function mount()
    {
        $this->locations = Location::all();
        $this->categories = HotelCategory::options();
        $this->category = HotelCategory::STANDARD->value; // Set default to STANDARD

        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['name'] = '';
        }
    }

    public function storeHotel()
    {
        $this->validate();

        $hotel = new Hotel();
        $hotel->name = $this->name;
        $hotel->category = HotelCategory::from($this->category);
        $hotel->location_id = $this->location_id;
        $hotel->save();

        // Save translations
        $fallbackLocale = config('app.fallback_locale');
        $this->trans[$fallbackLocale]['name'] = $this->name;

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $hotel->setTr($field, $locale, $value);
                }
            }
        }

        session()->flash('message', __('locations.hotel_created'));
        return redirect()->route('admin.hotels.index');
    }

    public function render()
    {
        return view('livewire.admin.hotel.hotel-create-component')->layout('layouts.app');
    }
}

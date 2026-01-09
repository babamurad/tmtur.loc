<?php

namespace App\Livewire\Admin\Place;

use App\Models\Place;
use App\Models\Location;
use App\Enums\PlaceType;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PlaceCreateComponent extends Component
{
    #[Rule('required')]
    public $name;

    #[Rule('required')]
    public $location_id;

    #[Rule('required')]
    public $type;

    public $cost;

    public array $trans = [];
    public $locations;
    public $types;

    protected function rules()
    {
        $rules = [
            'name' => 'required',
            'location_id' => 'required|exists:locations,id',
            'type' => 'required',
            'cost' => 'nullable|numeric',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.name"] = 'nullable|string|max:255';
        }

        return $rules;
    }

    public function mount()
    {
        $this->locations = Location::all();
        $this->types = PlaceType::options();
        $this->type = PlaceType::PAID->value; // Set default to PAID

        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['name'] = '';
        }
    }

    public function storePlace()
    {
        $this->validate();

        $place = new Place();
        $place->name = $this->name;
        $place->type = PlaceType::from($this->type);
        $place->cost = $this->cost;
        $place->location_id = $this->location_id;
        $place->save();

        // Save translations
        $fallbackLocale = config('app.fallback_locale');
        $this->trans[$fallbackLocale]['name'] = $this->name;

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $place->setTr($field, $locale, $value);
                }
            }
        }

        session()->flash('saved', [
            'title' => 'Место создано!',
            'text' => __('locations.place_created'),
        ]);
        return redirect()->route('admin.places.index');
    }

    public function render()
    {
        return view('livewire.admin.place.place-create-component')->layout('layouts.app');
    }
}

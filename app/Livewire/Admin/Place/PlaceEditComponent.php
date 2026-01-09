<?php

namespace App\Livewire\Admin\Place;

use App\Models\Place;
use App\Models\Location;
use App\Enums\PlaceType;
use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Livewire\Traits\HasGeminiTranslation;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class PlaceEditComponent extends Component
{
    use HasGeminiTranslation;
    public $place_id;

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

    public function mount($place_id)
    {
        $place = Place::find($place_id);
        $this->place_id = $place->id;
        $this->name = $place->name;
        $this->location_id = $place->location_id;
        $this->type = $place->type->value;
        $this->cost = $place->cost;

        $this->locations = Location::all();
        $this->types = PlaceType::options();

        // Load translations
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['name'] = $place->tr('name', $locale);
        }
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

        // Save translations
        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $place->setTr($field, $locale, $value);
                }
            }
        }

        session()->flash('saved', [
            'title' => 'Место обновлено!',
            'text' => __('locations.place_updated'),
        ]);
        return redirect()->route('admin.places.index');
    }

    protected function getTranslationContext(): string
    {
        return 'Место';
    }

    protected function getTranslatableFields(): array
    {
        return ['name'];
    }

    public function render()
    {
        return view('livewire.admin.place.place-edit-component')->layout('layouts.app');
    }
}

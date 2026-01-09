<?php

namespace App\Livewire\Admin\Hotel;

use App\Models\Hotel;
use App\Models\Location;
use App\Enums\HotelCategory;
use Livewire\Component;
use Livewire\Attributes\Rule;
use App\Livewire\Traits\HasGeminiTranslation;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class HotelEditComponent extends Component
{
    use HasGeminiTranslation;
    public $hotel_id;

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

    public function mount($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        $this->hotel_id = $hotel->id;
        $this->name = $hotel->name;
        $this->location_id = $hotel->location_id;
        $this->category = $hotel->category->value;

        $this->locations = Location::all();
        $this->categories = HotelCategory::options();

        // Load translations
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['name'] = $hotel->tr('name', $locale);
        }
    }

    public function updateHotel()
    {
        $this->validate();

        $hotel = Hotel::find($this->hotel_id);
        $hotel->name = $this->name;
        $hotel->category = HotelCategory::from($this->category);
        $hotel->location_id = $this->location_id;
        $hotel->save();

        // Save translations
        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $hotel->setTr($field, $locale, $value);
                }
            }
        }

        session()->flash('saved', [
            'title' => 'Отель обновлен!',
            'text' => __('locations.hotel_updated'),
        ]);
        return redirect()->route('admin.hotels.index');
    }

    protected function getTranslationContext(): string
    {
        return 'Отель';
    }

    protected function getTranslatableFields(): array
    {
        return ['name'];
    }

    public function render()
    {
        return view('livewire.admin.hotel.hotel-edit-component')->layout('layouts.app');
    }
}

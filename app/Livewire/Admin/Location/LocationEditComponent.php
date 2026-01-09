<?php

namespace App\Livewire\Admin\Location;

use App\Models\Location;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use App\Livewire\Traits\HasGeminiTranslation;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class LocationEditComponent extends Component
{
    use HasGeminiTranslation;
    public $location_id;

    #[Rule('required')]
    public $name;

    public $description;

    public array $trans = [];

    protected function rules()
    {
        $rules = [
            'name' => 'required',
            'description' => 'nullable',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.name"] = 'nullable|string|max:255';
            $rules["trans.$l.description"] = 'nullable|string';
        }

        return $rules;
    }

    public function mount($location_id)
    {
        $location = Location::find($location_id);
        $this->location_id = $location->id;
        $this->name = $location->name;
        $this->description = $location->description;

        // Load translations
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['name'] = $location->tr('name', $locale);
            $this->trans[$locale]['description'] = $location->tr('description', $locale);
        }
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function updateLocation()
    {
        $this->validate();

        $location = Location::find($this->location_id);
        $location->name = $this->name;
        $location->slug = Str::slug($this->name); // Auto-generate slug
        $location->description = $this->description;
        $location->save();

        // Save translations
        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $location->setTr($field, $locale, $value);
                }
            }
        }

        session()->flash('saved', [
            'title' => 'Локация обновлена!',
            'text' => __('locations.location_updated'),
        ]);
        return redirect()->route('admin.locations.index');
    }

    protected function getTranslationContext(): string
    {
        return 'Локация';
    }

    protected function getTranslatableFields(): array
    {
        return ['name', 'description'];
    }

    public function render()
    {
        return view('livewire.admin.location.location-edit-component')->layout('layouts.app');
    }
}

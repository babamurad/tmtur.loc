<?php

namespace App\Livewire\Admin\Location;

use App\Models\Location;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class LocationCreateComponent extends Component
{
    use \App\Livewire\Traits\HasGeminiTranslation;

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

    public function mount()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['name'] = '';
            $this->trans[$locale]['description'] = '';
        }
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function storeLocation($new = false)
    {
        $this->validate();

        $location = new Location();
        $location->name = $this->name;
        $location->slug = Str::slug($this->name); // Auto-generate slug
        $location->description = $this->description;
        $location->save();

        // Save translations
        $fallbackLocale = config('app.fallback_locale');
        $this->trans[$fallbackLocale]['name'] = $this->name;
        $this->trans[$fallbackLocale]['description'] = $this->description;

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $location->setTr($field, $locale, $value);
                }
            }
        }

        $message = __('locations.location_created');
        $route = $new ? route('admin.locations.create') : route('admin.locations.index');

        if ($new) {
            LivewireAlert::title($message)
                ->success()
                ->toast()
                ->position('top-end')
                ->show();

            $this->reset(['name', 'description']);
            foreach (config('app.available_locales') as $locale) {
                $this->trans[$locale]['name'] = '';
                $this->trans[$locale]['description'] = '';
            }
        } else {
            session()->flash('saved', [
                'title' => 'Локация создана!',
                'text' => $message,
            ]);
            return redirect()->route('admin.locations.index');
        }
    }

    protected function getTranslatableFields(): array
    {
        return ['name', 'description'];
    }

    protected function getTranslationContext(): string
    {
        return 'Локация';
    }

    public function render()
    {
        return view('livewire.admin.location.location-create-component')->layout('layouts.app');
    }
}

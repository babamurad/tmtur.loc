<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use App\Enums\ServiceType;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class ServiceEditComponent extends Component
{
    public $service;
    public $name;
    public $type;
    public $priceRub;
    public array $trans = [];

    protected function rules()
    {
        $rules = [
            'name'     => 'required|min:3|max:255',
            'type'     => 'required|in:' . ServiceType::ruleIn(),
            'priceRub' => 'numeric|nullable',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.name"] = 'nullable|string|max:255';
        }

        return $rules;
    }

    public function mount(Service $service)
    {
        $this->service = $service;
        $this->name = $service->name;
        $this->type = $service->type;
        $this->priceRub = $service->default_price_cents / 100;

        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['name'] = $service->tr('name', $locale);
        }
    }

    public function render()
    {
        return view('livewire.services.service-edit-component');
    }

    public function save()
    {
        $this->validate();

        $this->service->update([
            'name'                => $this->name,
            'type'                => $this->type,
            'default_price_cents' => $this->priceRub ? (int) round($this->priceRub * 100) : 0,
        ]);

        // Save translations
        $fallbackLocale = config('app.fallback_locale');
        $this->trans[$fallbackLocale]['name'] = $this->name;

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $this->service->setTr($field, $locale, $value);
            }
        }

        session()->flash('saved', [
        'title' => 'Услуга сохранена!',
        'text' => 'Изменения сохранились!',
        ]);
        return redirect()->route('services.index');
    }
}

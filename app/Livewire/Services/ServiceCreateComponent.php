<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use App\Enums\ServiceType;

class ServiceCreateComponent extends Component
{
    use \App\Livewire\Traits\HasGeminiTranslation;
    public $name;
    public $type;
    public $priceRub;
    public array $trans = [];

    protected function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'type' => 'required|in:' . ServiceType::ruleIn(),
            'priceRub' => 'numeric|nullable',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.name"] = 'nullable|string|max:255';
        }

        return $rules;
    }

    public function mount()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['name'] = '';
        }
    }

    public function render()
    {
        return view('livewire.services.service-create-component');
    }

    public function save()
    {
        $this->validate();

        $service = Service::create([
            'name' => $this->name,
            'type' => $this->type,
            'default_price_cents' => $this->priceRub ? (int) round($this->priceRub * 100) : 0,
        ]);

        // Save translations
        $fallbackLocale = config('app.fallback_locale');
        $this->trans[$fallbackLocale]['name'] = $this->name;

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $service->setTr($field, $locale, $value);
            }
        }

        session()->flash('saved', [
            'title' => 'Услуга создана!',
            'text' => 'Созадана новая услуга!',
        ]);
        return redirect()->route('services.index');
    }

    protected function getTranslatableFields(): array
    {
        return ['name'];
    }

    protected function getTranslationContext(): string
    {
        return 'Услуга';
    }
}

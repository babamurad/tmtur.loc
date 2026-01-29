<?php

namespace App\Livewire\Inclusions;

use App\Models\Inclusion;
use Livewire\Component;
use \App\Livewire\Traits\HasGeminiTranslation;

class InclusionCreateComponent extends Component
{
    use HasGeminiTranslation;
    public $trans = [];

    public function mount()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = '';
        }
    }

    protected function rules()
    {
        $rules = [];
        foreach (config('app.available_locales') as $locale) {
            $rules["trans.$locale.title"] = 'required|string|max:255';
        }
        return $rules;
    }

    public function save()
    {
        $this->validate();

        $fallbackLocale = config('app.fallback_locale');

        // Создаем запись с title из fallback языка
        $inclusion = Inclusion::create([
            'title' => $this->trans[$fallbackLocale]['title']
        ]);

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $inclusion->setTr($field, $locale, $value);
            }
        }

        session()->flash('message', 'Включение успешно создано.');
        return redirect()->route('inclusions.index');
    }

    public function render()
    {
        return view('livewire.inclusions.inclusion-create-component');
    }

    protected function getTranslatableFields(): array
    {
        return ['title'];
    }

    protected function getTranslationContext(): string
    {
        return 'Включения (услуги) тура';
    }
}

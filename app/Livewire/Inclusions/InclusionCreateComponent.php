<?php

namespace App\Livewire\Inclusions;

use App\Models\Inclusion;
use Livewire\Component;

class InclusionCreateComponent extends Component
{
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

        // Создаем пустую запись, так как таблица inclusions содержит только id и timestamps
        $inclusion = Inclusion::create([]);

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
}

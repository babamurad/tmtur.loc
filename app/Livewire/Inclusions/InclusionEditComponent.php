<?php

namespace App\Livewire\Inclusions;

use App\Models\Inclusion;
use Livewire\Component;

class InclusionEditComponent extends Component
{
    public $inclusion_id;
    public $trans = [];

    public function mount($id)
    {
        $this->inclusion_id = $id;
        $inclusion = Inclusion::findOrFail($id);

        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = $inclusion->tr('title', $locale);
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

        $inclusion = Inclusion::findOrFail($this->inclusion_id);
        
        $fallbackLocale = config('app.fallback_locale');
        
        // Обновляем title из fallback языка
        $inclusion->update([
            'title' => $this->trans[$fallbackLocale]['title']
        ]);

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $inclusion->setTr($field, $locale, $value);
            }
        }

        session()->flash('message', 'Включение успешно обновлено.');
        return redirect()->route('inclusions.index');
    }

    public function render()
    {
        return view('livewire.inclusions.inclusion-edit-component');
    }
}

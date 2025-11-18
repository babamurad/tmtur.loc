<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class TranslationManager extends Component
{
    public Model $model;           // переданная модель (Tour, Post …)
    public array  $fields;        // ['title','description']
    public array  $trans = [];    // [locale][field] => value

    protected $rules = [];

    public function mount(Model $model, array $fields = ['title','description'])
    {
        $this->model  = $model;
        $this->fields = $fields;

        // заполняем текущие переводы
        foreach (config('app.available_locales',['en','ru','de']) as $locale) {
            foreach ($fields as $f) {
                $this->trans[$locale][$f] = $model->tr($f, $locale);
            }
        }

        // динамически строим правила валидации
        foreach ($fields as $f) {
            foreach (config('app.available_locales') as $l) {
                $this->rules["trans.$l.$f"] = 'nullable|string|max:65000';
            }
        }
    }

    public function save()
    {
        $this->validate();

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $this->model->setTr($field, $locale, $value);
            }
        }

        session()->flash('message','Переводы сохранены');
    }

    public function render()
    {
        return view('livewire.translation-manager');
    }
}

<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $current;

    public function mount()
    {
        $this->current = session('locale', config('app.locale'));
    }

    public function switch(string $locale)
    {
        if (! in_array($locale, config('app.available_locales'))) {
            return;
        }

        App::setLocale($locale);
        session()->put('locale', $locale);
        $this->current = $locale;

        // перезагружаем всю страницу, чтобы переводы сразу применились
        $this->dispatch('languageChanged');
    }

    public function render()
    {
        return view('livewire.language-switcher', [
            'locales' => config('app.available_locales'),
        ]);
    }
}

<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class TagCreateComponent extends Component
{
    public array $names = []; // Stores name for each locale: ['ru' => '...', 'en' => '...']

    public function mount()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->names[$locale] = '';
        }
    }

    public function save()
    {
        $this->validate([
            'names.' . config('app.fallback_locale') => 'required|string|max:255',
        ]);

        Tag::create([
            'name' => $this->names,
        ]);

        LivewireAlert::title('Тег создан')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
            
        return redirect()->route('admin.tags.index');
    }

    public function render()
    {
        return view('livewire.tags.tag-create-component')
            ->layout('layouts.app');
    }
}

<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use App\Livewire\Traits\HasGeminiTranslation;

class TagCreateComponent extends Component
{
    use HasGeminiTranslation;

    public array $trans = [];

    public function mount()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['name'] = '';
        }
    }

    public function save()
    {
        $this->validate([
            'trans.' . config('app.fallback_locale') . '.name' => 'required|string|max:255',
        ]);

        $names = [];
        foreach (config('app.available_locales') as $locale) {
            $names[$locale] = $this->trans[$locale]['name'] ?? '';
        }

        Tag::create([
            'name' => $names,
        ]);

        LivewireAlert::title('Тег создан')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();

        return redirect()->route('admin.tags.index');
    }

    protected function getTranslatableFields(): array
    {
        return ['name'];
    }

    protected function getTranslationContext(): string
    {
        return 'Тег';
    }

    public function render()
    {
        return view('livewire.tags.tag-create-component')
            ->layout('layouts.app');
    }
}

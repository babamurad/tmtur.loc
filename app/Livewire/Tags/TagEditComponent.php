<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use App\Livewire\Traits\HasGeminiTranslation;

class TagEditComponent extends Component
{
    use HasGeminiTranslation;

    public Tag $tag;
    public array $trans = [];

    public function mount($id)
    {
        $this->tag = Tag::findOrFail($id);

        // Load existing translations from the JSON column
        $existingNames = $this->tag->name; // This is an array due to casting

        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['name'] = $existingNames[$locale] ?? '';
        }
    }

    public function save()
    {
        $names = [];
        foreach (config('app.available_locales') as $locale) {
            $names[$locale] = $this->trans[$locale]['name'] ?? '';
        }

        $this->tag->name = $names;
        $this->tag->save();

        LivewireAlert::title('Тег обновлен')
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
        return view('livewire.tags.tag-edit-component')
            ->layout('layouts.app');
    }
}

<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class TagEditComponent extends Component
{
    public Tag $tag;
    public array $names = []; // Stores name for each locale: ['ru' => '...', 'en' => '...']

    public function mount($id)
    {
        $this->tag = Tag::findOrFail($id);
        
        // Load existing translations from the JSON column
        $existingNames = $this->tag->name; // This is an array due to casting
        
        foreach (config('app.available_locales') as $locale) {
            $this->names[$locale] = $existingNames[$locale] ?? '';
        }
    }

    public function save()
    {
        // Filter out empty strings? Or keep them as is? 
        // Better to save what is entered.
        
        $this->tag->name = $this->names;
        $this->tag->save();

        LivewireAlert::title('Тег обновлен')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
            
        return redirect()->route('admin.tags.index');
    }

    public function render()
    {
        return view('livewire.tags.tag-edit-component')
            ->layout('layouts.app');
    }
}

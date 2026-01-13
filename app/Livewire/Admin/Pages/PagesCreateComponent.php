<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class PagesCreateComponent extends Component
{
    use \App\Livewire\Traits\HasGeminiTranslation;

    #[Rule('required')]
    public $title;

    public $slug;

    public $content;

    public $is_published = true;

    public array $trans = [];

    protected function rules()
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:pages,slug',
            'content' => 'nullable',
            'is_published' => 'boolean',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.content"] = 'nullable|string';
        }

        return $rules;
    }

    public function updatedTitle()
    {
        $this->slug = Str::slug($this->title);
    }

    public function mount()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = '';
            $this->trans[$locale]['content'] = '';
        }
    }

    public function storePage($new = false)
    {
        $this->validate();

        $page = new Page();
        $page->slug = $this->slug;
        $page->is_published = $this->is_published;
        $page->save();

        // Save translations
        // Note: For 'ru' (fallback) we are mapping $this->title to trans array?
        // Actually, usually we save fallback content to main fields if they exist in table? 
        // My Page migration has title/content columns. 
        // So I should save to them.

        $page->title = $this->title;
        $page->content = $this->content;
        $page->save(); // Save again to update main fields

        // Also save to translation table for consistency if trait relies on it?
        // Trait `tr()` uses Translation table first.

        // Let's populate trans array for fallback locale too if not set
        $fallbackLocale = config('app.fallback_locale');
        $this->trans[$fallbackLocale]['title'] = $this->title;
        $this->trans[$fallbackLocale]['content'] = $this->content;

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $page->setTr($field, $locale, $value);
                }
            }
        }

        $message = 'Страница создана успешно';

        if ($new) {
            LivewireAlert::title($message)
                ->success()
                ->toast()
                ->position('top-end')
                ->show();

            $this->reset(['title', 'slug', 'content', 'is_published']);
            foreach (config('app.available_locales') as $locale) {
                $this->trans[$locale]['title'] = '';
                $this->trans[$locale]['content'] = '';
            }
        } else {
            session()->flash('saved', [
                'title' => 'Успешно!',
                'text' => $message,
            ]);
            return redirect()->route('admin.pages.index');
        }
    }

    protected function getTranslatableFields(): array
    {
        return ['title', 'content'];
    }

    protected function getTranslationContext(): string
    {
        return 'Static Page content';
    }

    public function render()
    {
        return view('livewire.admin.pages.pages-create-component')->layout('layouts.app');
    }
}

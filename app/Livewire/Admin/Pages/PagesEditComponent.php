<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class PagesEditComponent extends Component
{
    use \App\Livewire\Traits\HasGeminiTranslation;

    public $page_id;

    #[Rule('required')]
    public $title;

    public $slug;

    public $content;

    public $is_published;

    public array $trans = [];

    protected function rules()
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:pages,slug,' . $this->page_id,
            'content' => 'nullable',
            'is_published' => 'boolean',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.content"] = 'nullable|string';
        }

        return $rules;
    }

    public function mount($id)
    {
        $page = Page::findOrFail($id);
        $this->page_id = $page->id;
        $this->slug = $page->slug;
        $this->is_published = $page->is_published;

        // Load fallback/main locale
        // Assuming default locale is RU.
        // We load main fields using tr() to get the correct language content even if it was stored as translation
        $fallback = config('app.fallback_locale');
        $this->title = $page->tr('title', $fallback);
        $this->content = $page->tr('content', $fallback);

        // Load translations
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = $page->tr('title', $locale);
            $this->trans[$locale]['content'] = $page->tr('content', $locale);
        }
    }

    public function updatePage()
    {
        $this->validate();

        $page = Page::findOrFail($this->page_id);
        $page->slug = $this->slug;
        $page->title = $this->title;
        $page->content = $this->content;
        $page->is_published = $this->is_published;
        $page->save();

        // Update translations
        $fallbackLocale = config('app.fallback_locale');
        $this->trans[$fallbackLocale]['title'] = $this->title;
        $this->trans[$fallbackLocale]['content'] = $this->content;

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                // If it's a translation, save it
                // Note: we might want to allow empty strings to clear translation if needed?
                // But typically we update if set.
                $page->setTr($field, $locale, $value);
            }
        }

        session()->flash('saved', [
            'title' => 'Успешно!',
            'text' => 'Страница обновлена',
        ]);
        return redirect()->route('admin.pages.index');
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
        return view('livewire.admin.pages.pages-edit-component')->layout('layouts.app');
    }
}

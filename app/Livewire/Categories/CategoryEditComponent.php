<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoryEditComponent extends Component
{
    use WithFileUploads;
    use \App\Livewire\Traits\HasGeminiTranslation;

    public Category $category;
    public string $title;
    public string $slug;
    public string $content = '';
    public bool $is_published;
    public $newImage;

    public array $trans = [];

    protected function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255|unique:categories,title,' . $this->category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $this->category->id,
            'content' => 'nullable|string',
            'newImage' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.content"] = 'nullable|string';
        }

        return $rules;
    }

    public function mount($id): void
    {
        $this->category = Category::findOrFail($id);
        $this->title = $this->category->title;
        $this->slug = $this->category->slug;
        $this->content = $this->category->content;
        $this->is_published = (bool) $this->category->is_published;

        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = $this->category->tr('title', $locale);
            $this->trans[$locale]['content'] = $this->category->tr('content', $locale);
        }
    }

    public function updatedTitle($value): void
    {
        $this->slug = \Str::slug($value);
    }

    public function save(): void
    {
        $fallback = config('app.fallback_locale');
        $this->trans[$fallback]['title'] = $this->title;
        $this->trans[$fallback]['content'] = $this->content;

        $this->validate();

        if ($this->newImage) {
            $this->category->image && \Storage::disk('public_uploads')->delete($this->category->image);
            $this->category->image = $this->newImage->store('categories', 'public_uploads');
        }

        $this->category->update([
            'title' => $this->title,
            'slug' => $this->slug ?: \Str::slug($this->title),
            'content' => $this->content,
            'is_published' => $this->is_published,
        ]);

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $this->category->setTr($field, $locale, $value);
            }
        }

        session()->flash('success', 'Категория обновлена.');
        $this->redirectRoute('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.category-edit-component');
    }

    protected function getTranslatableFields(): array
    {
        return ['title', 'content'];
    }

    protected function getTranslationContext(): string
    {
        return 'Категория блога';
    }
}

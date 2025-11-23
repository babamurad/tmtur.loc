<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoryCreateComponent extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $slug = '';
    public string $content = '';
    public bool $is_published = false;
    public $image;

    public array $trans = [];

    protected function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255|unique:categories',
            'slug'  => 'nullable|string|max:255|unique:categories',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.content"] = 'nullable|string';
        }

        return $rules;
    }

    public function mount()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = '';
            $this->trans[$locale]['content'] = '';
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

        $filename = null;
        if ($this->image) {
            $filename = $this->image->store('categories', 'public_uploads');
        }

        $category = Category::create([
            'title' => $this->title,
            'slug'  => $this->slug ?: \Str::slug($this->title),
            'content' => $this->content,
            'image' => $filename,
            'is_published' => $this->is_published,
        ]);

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $category->setTr($field, $locale, $value);
            }
        }

        session()->flash('success', 'Категория создана.');
        $this->redirectRoute('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.category-create-component');
    }
}

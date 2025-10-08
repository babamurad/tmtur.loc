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

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:categories',
            'slug'  => 'nullable|string|max:255|unique:categories',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ];
    }

    public function updatedTitle($value): void
    {
        $this->slug = \Str::slug($value);
    }

    public function save(): void
    {
        $this->validate();

        $filename = null;
        if ($this->image) {
            $filename = $this->image->store('categories', 'public_uploads');
        }

        Category::create([
            'title' => $this->title,
            'slug'  => $this->slug ?: \Str::slug($this->title),
            'content' => $this->content,
            'image' => $filename,
            'is_published' => $this->is_published,
        ]);

        session()->flash('success', 'Категория создана.');
        $this->redirectRoute('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.category-create-component');
    }
}

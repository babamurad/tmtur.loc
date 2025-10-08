<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoryEditComponent extends Component
{
    use WithFileUploads;

    public Category $category;
    public string $title;
    public string $slug;
    public string $content = '';
    public bool $is_published;
    public $newImage;

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:categories,title,' . $this->category->id,
            'slug'  => 'nullable|string|max:255|unique:categories,slug,' . $this->category->id,
            'content' => 'nullable|string',
            'newImage' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ];
    }

    public function mount($id): void
    {
        $this->category = Category::findOrFail($id);
        $this->title = $this->category->title;
        $this->slug = $this->category->slug;
        $this->content = $this->category->content;
        $this->is_published = (bool)$this->category->is_published;
    }

    public function updatedTitle($value): void
    {
        $this->slug = \Str::slug($value);
    }

    public function save(): void
    {
        $this->validate();

        if ($this->newImage) {
            $this->category->image && \Storage::disk('public')->delete($this->category->image);
            $this->category->image = $this->newImage->store('categories', 'public');
        }

        $this->category->update([
            'title' => $this->title,
            'slug'  => $this->slug ?: \Str::slug($this->title),
            'content' => $this->content,
            'is_published' => $this->is_published,
        ]);

        session()->flash('success', 'Категория обновлена.');
        $this->redirectRoute('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.category-edit-component');
    }
}

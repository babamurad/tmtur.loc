<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class CategoryIndexComponent extends Component
{
    use WithPagination;

    public int $perPage = 8;
    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteConfirm(int $id): void
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Удалить категорию?',
            'text'  => 'Восстановление будет невозможно',
            'id'    => $id,
            'event' => 'category:delete',
        ]);
    }

    #[On('category:delete')]
    public function delete(int $id): void
    {
        Category::findOrFail($id)->delete();
        session()->flash('success', 'Категория удалена.');
    }

    public function render()
    {
        $categories = Category::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.categories.category-index-component', compact('categories'));
    }
}

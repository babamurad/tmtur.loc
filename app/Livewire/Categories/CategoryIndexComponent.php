<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class CategoryIndexComponent extends Component
{
    use WithPagination;

    public int $perPage = 8;
    public string $search = '';
    public $delId;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteConfirm($id)
    {
        $this->delId = $id;
        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить тур?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('delete')
            ->show();
    }

    public function delete()
    {
        $category =  Category::findOrFail($this->delId);
        $category->delete();

        LivewireAlert::title('Категория удалена.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function mount()
    {
        if (session()->has('saved')) {
            LivewireAlert::title(session('saved.title'))
                ->text(session('saved.text'))
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        }
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

<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class PostIndexComponent extends Component
{
    use WithPagination;

    public int $perPage = 8;
    public string $search = '';
    public ?int $delId = null;

    /* поиск → сброс страницы */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /* подтверждение удаления */
    public function deleteConfirm(int $id): void
    {
        $this->delId = $id;
        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить пост?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('delete')
            ->show();
    }

    /* событие подтверждения */
    #[On('delete')]
    public function delete(): void
    {
        Post::findOrFail($this->delId)->delete();

        LivewireAlert::title('Пост удалён.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    /* flashes после редиректов create / edit */
    public function mount(): void
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

    /* рендер */
    public function render()
    {
        $posts = Post::with('category')
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.posts.post-index-component', compact('posts'));
    }
}

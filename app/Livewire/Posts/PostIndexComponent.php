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
        LivewireAlert::title('Удалить пост?')
            ->timer(null)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('destroy')
            ->show();
    }

    /* событие подтверждения */
    public function destroy(): void
    {
        try {
            $post = Post::findOrFail($this->delId);

            // Удаляем изображение, если оно существует
            if ($post->image) {
                $imagePath = strpos($post->image, 'posts/') === 0 ? $post->image : 'posts/' . $post->image;
                if (file_exists(public_path('uploads/' . $imagePath))) {
                    unlink(public_path('uploads/' . $imagePath));
                }
            }

            $post->delete();

            LivewireAlert::title('Пост успешно удалён')
                ->success()
                ->show();

        } catch (\Exception $e) {
            LivewireAlert::title('Ошибка при удалении поста')
                ->error()
                ->show();
        }
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

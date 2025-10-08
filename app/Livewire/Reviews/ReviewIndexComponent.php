<?php

namespace App\Livewire\Reviews;

use App\Models\Review;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ReviewIndexComponent extends Component
{
    use WithPagination;

    public int $perPage         = 8;
    public string $search       = '';
    public ?int $delId          = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /* подтверждение удаления */
    public function deleteConfirm(int $id): void
    {
        $this->delId = $id;
        LivewireAlert::title('Удалить отзыв?')
            ->text('После удаления восстановление невозможно')
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
        Review::findOrFail($this->delId)->delete();

        LivewireAlert::title('Отзыв удалён!')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    /* flash после create / edit */
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

    public function render()
    {
        $reviews = Review::with(['user:id,name', 'tour:id,title'])
            ->when($this->search, fn($q) => $q->where('comment', 'like', "%{$this->search}%"))
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.reviews.review-index-component', compact('reviews'));
    }
}

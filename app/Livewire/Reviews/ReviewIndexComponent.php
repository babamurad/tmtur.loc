<?php

namespace App\Livewire\Reviews;

use App\Models\Review;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewIndexComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 12;
    public string $search = '';
    public ?int $delId = null;

    protected $listeners = ['deleteConfirmed'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $this->delId = $id;

        LivewireAlert::title('Удалить отзыв?')
            ->text('Вы уверены, что хотите удалить этот отзыв? Восстановление невозможно.')
            ->timer(5000)
            ->withConfirmButton('Да, удалить')
            ->withCancelButton('Отмена')
            ->onConfirm('deleteConfirmed')
            ->show(null, ['backdrop' => true]);
    }

    public function deleteConfirmed(): void
    {
        $review = Review::find($this->delId);

        if ($review) {
            $review->delete();

            LivewireAlert::title('Отзыв удалён!')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    public function toggleActive($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_active' => !$review->is_active]);

        LivewireAlert::title($review->is_active ? 'Отзыв опубликован' : 'Отзыв скрыт')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

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
        $reviews = Review::with(['user.avatar', 'tour'])
            ->when($this->search, fn($q) => $q->where('comment', 'like', "%{$this->search}%"))
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.reviews.review-index-component', compact('reviews'))
            ->layout('layouts.app');
    }
}

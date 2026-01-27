<?php

namespace App\Livewire\Reviews;

use App\Models\Review;
use App\Models\Tour;
use App\Models\User;
use Livewire\Component;

class ReviewCreateComponent extends Component
{
    public int $user_id = 0;
    public int $tour_id = 0;
    public int $rating = 5;
    public ?string $comment = null;
    public bool $is_active = true;

    protected function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'tour_id' => 'required|exists:tours,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
            'is_active' => 'boolean',
        ];
    }

    public function save()
    {
        \Log::info('Попытка сохранения отзыва', [
            'user_id' => $this->user_id,
            'tour_id' => $this->tour_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'is_active' => $this->is_active,
        ]);

        try {
            $this->validate();

            $review = Review::create([
                'user_id' => $this->user_id,
                'tour_id' => $this->tour_id,
                'rating' => $this->rating,
                'comment' => $this->comment,
                'is_active' => $this->is_active,
            ]);

            \Log::info('Отзыв успешно создан', ['review_id' => $review->id]);

            session()->flash('saved', [
                'title' => 'Отзыв добавлен!',
                'text' => 'Новый отзыв успешно создан.',
            ]);

            return $this->redirectRoute('admin.reviews.index');

        } catch (\Exception $e) {
            \Log::error('Ошибка при создании отзыва', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('error', [
                'title' => 'Ошибка',
                'text' => 'Не удалось создать отзыв: ' . $e->getMessage(),
            ]);
        }
    }


    public function render()
    {
        return view('livewire.reviews.review-create-component', [
            'users' => User::select('id', 'name')->orderBy('name')->get(),
            'tours' => Tour::select('id', 'title')->orderBy('title')->get(),
        ]);
    }
}

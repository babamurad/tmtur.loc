<?php

namespace App\Livewire\Reviews;

use App\Models\Review;
use App\Models\Tour;
use App\Models\User;
use Livewire\Component;

class ReviewEditComponent extends Component
{
    public Review $review;
    public int $user_id;
    public int $tour_id;
    public int $rating;
    public ?string $comment = null;
    public bool $is_active = false;

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

    public function mount(Review $review)
    {
        $this->review = $review;
        $this->user_id = $review->user_id;
        $this->tour_id = $review->tour_id;
        $this->rating = $review->rating;
        $this->comment = $review->comment;
        $this->is_active = $review->is_active;
    }

    public function save()
    {
        $this->validate();

        $this->review->update([
            'user_id' => $this->user_id,
            'tour_id' => $this->tour_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'is_active' => $this->is_active,
        ]);

        session()->flash('saved', [
            'title' => 'Отзыв обновлён!',
            'text' => 'Изменения сохранены.',
        ]);
        return $this->redirectRoute('reviews.index');
    }

    public function render()
    {
        return view('livewire.reviews.review-edit-component', [
            'users' => User::select('id', 'name')->orderBy('name')->get(),
            'tours' => Tour::select('id', 'title')->orderBy('title')->get(),
        ]);
    }
}

<?php

namespace App\Livewire\Reviews;

use App\Models\Review;
use App\Models\Tour;
use App\Models\User;
use Livewire\Component;

class ReviewCreateComponent extends Component
{
    public int $user_id   = 0;
    public int $tour_id   = 0;
    public int $rating    = 5;
    public ?string $comment = null;

    protected function rules(): array
    {
        return [
            'user_id'  => 'required|exists:users,id',
            'tour_id'  => 'required|exists:tours,id',
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'nullable|string|max:2000',
        ];
    }

    public function save()
    {
        $this->validate();

        Review::create([
            'user_id'  => $this->user_id,
            'tour_id'  => $this->tour_id,
            'rating'   => $this->rating,
            'comment'  => $this->comment,
        ]);

        session()->flash('saved', [
            'title' => 'Отзыв добавлен!',
            'text'  => 'Новый отзыв успешно создан.',
        ]);
        return $this->redirectRoute('reviews.index');
    }

    public function render()
    {
        return view('livewire.reviews.review-create-component', [
            'users' => User::select('id', 'name')->orderBy('name')->get(),
            'tours' => Tour::select('id', 'title')->orderBy('title')->get(),
        ]);
    }
}

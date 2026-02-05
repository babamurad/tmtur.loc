<?php

namespace App\Livewire\Front;

use App\Models\Review;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;


class ReviewsIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $rating = 5;
    public ?string $comment = '';
    public ?int $tour_id = null;

    public ?int $editingReviewId = null;

    protected function rules()
    {
        return [
            'tour_id' => 'nullable|exists:tours,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:2000',
        ];
    }

    public function edit($id)
    {
        $review = Review::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $this->editingReviewId = $review->id;
        $this->tour_id = $review->tour_id;
        $this->rating = $review->rating;
        $this->comment = $review->comment;

        $this->dispatch('open-modal');
    }

    public function save()
    {
        if (!auth()->check()) {
            return redirect()->route('front.login');
        }

        $this->validate();

        if ($this->editingReviewId) {
            $review = Review::where('id', $this->editingReviewId)->where('user_id', auth()->id())->firstOrFail();
            $review->update([
                'tour_id' => $this->tour_id,
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);
            session()->flash('message', __('messages.review_updated_success'));
        } else {
            Review::create([
                'user_id' => auth()->id(),
                'tour_id' => $this->tour_id,
                'rating' => $this->rating,
                'comment' => $this->comment,
                'is_active' => false, // Moderation enabled
            ]);
            session()->flash('message', __('messages.review_submitted_success'));
        }

        $this->reset(['rating', 'comment', 'tour_id', 'editingReviewId']);

        $this->dispatch('close-modal');
    }

    public function getToursProperty()
    {
        return \App\Models\Tour::select('id', 'title')->orderBy('title')->get();
    }

    public function render()
    {
        $reviews = Review::active()
            ->with(['user.avatar', 'tour'])
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('livewire.front.reviews-index', [
            'reviews' => $reviews,
            'tours' => $this->tours,
        ])->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

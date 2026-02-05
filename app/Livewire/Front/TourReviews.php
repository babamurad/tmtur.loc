<?php

namespace App\Livewire\Front;

use App\Models\Review;
use App\Models\Tour;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TourReviews extends Component
{
    use WithPagination;

    public Tour $tour;

    #[Rule('required|integer|min:1|max:5')]
    public $rating = 5;

    #[Rule('required|string|min:10|max:1000')]
    public $comment = '';

    public ?int $editingReviewId = null;

    public function mount(Tour $tour)
    {
        $this->tour = $tour;
    }

    public function edit($id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $this->editingReviewId = $review->id;
        $this->rating = $review->rating;
        $this->comment = $review->comment;
    }

    public function cancelEdit()
    {
        $this->reset(['rating', 'comment', 'editingReviewId']);
    }

    public function save()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();

        if ($this->editingReviewId) {
            $review = Review::where('id', $this->editingReviewId)->where('user_id', Auth::id())->firstOrFail();
            $review->update([
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);
            session()->flash('message', __('messages.review_updated_success'));
        } else {
            Review::create([
                'user_id' => Auth::id(),
                'tour_id' => $this->tour->id,
                'rating' => $this->rating,
                'comment' => $this->comment,
                'is_active' => false, // Moderation enabled
            ]);
            session()->flash('message', __('messages.review_submitted_success'));
        }

        $this->reset(['rating', 'comment', 'editingReviewId']);
    }

    public function render()
    {
        $reviews = $this->tour->reviews()
            ->active()
            ->with('user')
            ->latest()
            ->paginate(5);

        return view('livewire.front.tour-reviews', [
            'reviews' => $reviews
        ]);
    }
}

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

    public function mount(Tour $tour)
    {
        $this->tour = $tour;
    }

    public function save()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();

        Review::create([
            'user_id' => Auth::id(),
            'tour_id' => $this->tour->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'is_active' => false,
        ]);

        $this->reset(['rating', 'comment']);

        session()->flash('message', __('messages.review_submitted_success'));
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

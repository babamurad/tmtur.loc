<?php

namespace App\Livewire\Front;

use App\Models\Review;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.front-app')]
class ReviewsIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $rating = 5;
    public ?string $comment = '';
    public ?int $tour_id = null;

    protected function rules()
    {
        return [
            'tour_id' => 'required|exists:tours,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:2000',
        ];
    }

    public function save()
    {
        if (!auth()->check()) {
            return redirect()->route('front.login');
        }

        $this->validate();

        Review::create([
            'user_id' => auth()->id(),
            'tour_id' => $this->tour_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'is_active' => true, // Auto-approve for now
        ]);

        $this->reset(['rating', 'comment', 'tour_id']);

        // Close modal (using browser event dispatch if using Alpine/JS or just session flash)
        // We'll use session flash to show success message
        session()->flash('message', __('messages.review_submitted_success'));

        $this->dispatch('review-added'); // To close modal if needed
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
        ]);
    }
}

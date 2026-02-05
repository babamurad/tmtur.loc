<div class="mt-5">
    <h3 class="mb-2">{{ __('messages.reviews_title') }} ({{ $reviews->total() }})</h3>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Список отзывов --}}
    <div class="mb-4 ">
        @forelse ($reviews as $review)
            <div class="card mb-3 shadow-sm border p-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                style="width: 40px; height: 40px;">
                                {{ substr($review->user->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $review->user->name ?? __('messages.review_user_fallback') }}</h6>
                                <small class="text-muted">{{ $review->created_at->format('d.m.Y H:i') }}</small>
                            </div>
                        </div>
                        <div class="text-warning">
                            @for ($i = 1; $i <= (int)$review->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="card-text">{{ $review->comment }}</p>
                </div>
            </div>
                @if(Auth::id() === $review->user_id)
                    <div class="card-footer bg-transparent border-0 text-right p-2">
                        <button wire:click="edit({{ $review->id }})" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                        </button>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-muted">{{ __('messages.no_reviews_yet') }}</p>
        @endforelse

        {{ $reviews->links() }}
    </div>

    {{-- Форма отзыва --}}
    <div class="card bg-light mb-3" id="review-form">
        <div class="card-body">
            <h5 class="card-title mb-3">
                {{ $editingReviewId ? __('messages.edit_review_title') : __('messages.leave_review_title') }}
            </h5>

            @auth
                <form wire:submit="save">
                    <div class="form-group mb-3">
                        <label>{{ __('messages.your_rating_label') }}</label>
                        <div class="rating-input text-warning" style="font-size: 1.5rem; cursor: pointer;">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $rating ? 'fa-solid' : 'fa-regular' }} fa-star"
                                    wire:click="$set('rating', {{ $i }})"></i>
                            @endfor
                        </div>
                        @error('rating') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="comment">{{ __('messages.comment_label') }}</label>
                        <textarea wire:model="comment" id="comment"
                            class="form-control @error('comment') is-invalid @enderror" rows="3"
                            placeholder="{{ __('messages.comment_placeholder') }}"></textarea>
                        @error('comment') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="save">
                                {{ $editingReviewId ? __('messages.update_review_btn') : __('messages.submit_review_btn') }}
                            </span>
                            <span wire:loading wire:target="save"><i class="fas fa-spinner fa-spin"></i>
                                {{ __('messages.sending_btn') }}</span>
                        </button>

                        @if($editingReviewId)
                            <button type="button" wire:click="cancelEdit" class="btn btn-secondary btn-sm">
                                {{ __('messages.modal_cancel_button') }}
                            </button>
                        @endif
                    </div>
                </form>
            @else
                <div class="alert alert-info mb-0">
                    {!! __('messages.login_to_review_text', ['login_url' => route('front.login')]) !!}
                </div>
            @endauth
        </div>
    </div>
</div>
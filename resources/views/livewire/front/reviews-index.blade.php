<div class="mt-5 pt-2 container">
    {{-- SEO --}}
    @section('title', __('messages.reviews_page_title'))
    @section('description', __('messages.reviews_page_description'))

    {{-- Breadcrumb --}}
    <div class="breadcrumb-area breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content text-center">
                        <h2 class="title">{{ __('messages.reviews_page_title') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('menu.home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('menu.reviews') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reviews Content --}}
    <section class="testimonial-area py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    {{-- Section title removed as per user request --}}

                    <div class="text-center mb-4">
                        @auth
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reviewModal">
                                <i class="fas fa-pen me-2"></i> {{ __('messages.leave_review_title') }}
                            </button>
                        @else
                            <a href="{{ route('front.login') }}" class="btn btn-primary" data-toggle="tooltip"
                                title="{{ __('messages.login_to_review_tooltip') }}">
                                <i class="fas fa-lock me-2"></i> {{ __('messages.login_to_review_tooltip') }}
                            </a>
                        @endauth
                    </div>

                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Review Modal -->
            <div wire:ignore.self class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title" id="reviewModalLabel">
                                {{ $editingReviewId ? __('messages.edit_review_title') : __('messages.leave_review_title') }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" style="padding: 2rem !important;">
                            <form wire:submit.prevent="save">
                                <div class="mb-3 form-group">
                                    <label for="tour_id" class="form-label">{{ __('messages.choose_tour_label') }} <span
                                            class="text-muted small">({{ __('messages.optional') }})</span></label>
                                    <select class="form-control form-select @error('tour_id') is-invalid @enderror"
                                        id="tour_id" wire:model.live="tour_id">
                                        <option value="">{{ __('messages.choose_tour_placeholder') }}</option>
                                        @foreach($tours as $tour)
                                            <option value="{{ $tour->id }}">{{ $tour->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('tour_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3 form-group">
                                    <label class="form-label">{{ __('messages.your_rating_label') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="rating-input text-warning" style="font-size: 1.5rem; cursor: pointer;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $rating ? 'fa-solid' : 'fa-regular' }} fa-star"
                                                wire:click="$set('rating', {{ $i }})"></i>
                                        @endfor
                                    </div>
                                    @error('rating') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3 form-group">
                                    <label for="comment" class="form-label">{{ __('messages.comment_label') }} <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control @error('comment') is-invalid @enderror" id="comment"
                                        rows="4" wire:model.live="comment"
                                        placeholder="{{ __('messages.comment_placeholder') }}"></textarea>
                                    @error('comment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="d-grid form-group mb-0">
                                    <button type="submit" class="btn btn-primary btn-block"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove>
                                            {{ $editingReviewId ? __('messages.update_review_btn') : __('messages.submit_review_btn') }}
                                        </span>
                                        <span wire:loading><i class="fas fa-spinner fa-spin"></i>
                                            {{ __('messages.sending_btn') }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('livewire:initialized', () => {
                @this.on('close-modal', (event) => {
                    $('#reviewModal').modal('hide');
                });
                @this.on('open-modal', (event) => {
                    $('#reviewModal').modal('show');
                });
            });
        </script>

        <div class="row">
            @forelse($reviews as $review)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="testimonial-item testimonial-item-two card h-100 border shadow-sm p-4">
                        <div class="testimonial-content card-body d-flex flex-column">
                            <div class="rating mb-2">
                                @for($i = 1; $i <= (int) $review->rating; $i++)
                                    <i class="fa-solid fa-star text-warning small"></i>
                                @endfor
                            </div>
                            <p class="card-text flex-grow-1">{{ Str::limit($review->comment, 150) }}</p>
                            <div class="testimonial-avatar mt-3 d-flex align-items-center">
                                <div class="avatar-thumb mr-3">
                                    <img src="{{ $review->user->avatar->url ?? asset('assets/images/users/default-user.jpeg') }}"
                                        class="rounded-circle" alt="{{ $review->user->name ?? 'Пользователь' }}"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                </div>
                                <div class="avatar-info">
                                    <h6 class="title mb-0">{{ $review->user->name ?? 'Пользователь' }}</h6>
                                    <small class="date text-muted">{{ $review->created_at->format('d.m.Y') }}</small>
                                </div>
                            </div>
                            <p class="small text-muted mb-2">
                                @if($review->tour)
                                    <i class="fas fa-map-marker-alt mr-1"></i> <a
                                        href="{{ route('tours.show', $review->tour->slug) }}" class="text-muted">
                                        {{ $review->tour->title }}
                                    </a>
                                @else
                                    <i class="fas fa-globe mr-1"></i> {{ __('messages.general_review') }}
                                @endif
                            </p>
                        </div>
                        @auth
                            @if(auth()->id() === $review->user_id)
                                <div class="card-footer bg-transparent border-0 text-right">
                                    <button wire:click="edit({{ $review->id }})" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> {{ __('messages.edit') }}
                                    </button>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>Пока нет отзывов.</p>
                </div>
            @endforelse
        </div>

        <div class="row">
            <div class="col-12">
                <div class="pagination-wrap mt-30 text-center">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
</div>
</section>
</div>
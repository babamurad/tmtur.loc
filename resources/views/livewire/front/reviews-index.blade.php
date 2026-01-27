<div>
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
                    <div class="section-title text-center mb-50">
                        <span class="sub-title">{{ __('messages.our_reviews') }}</span>
                        <h2 class="title">{{ __('messages.what_travelers_say') }}</h2>
                    </div>

                    <div class="text-center mb-4">
                        @auth
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#reviewModal">
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
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Review Modal -->
            <div wire:ignore.self class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reviewModalLabel">{{ __('messages.leave_review_title') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="save">
                                <div class="mb-3 form-group">
                                    <label for="tour_id" class="form-label">{{ __('messages.select_tour_label') }} <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control form-select @error('tour_id') is-invalid @enderror" id="tour_id"
                                        wire:model.live="tour_id">
                                        <option value="">{{ __('messages.choose_tour_placeholder') }}</option>
                                        @foreach($tours as $tour)
                                            <option value="{{ $tour->id }}">{{ $tour->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('tour_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3 form-group">
                                    <label class="form-label">{{ __('messages.your_rating_label') }} <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <div class="form-check form-check-inline custom-control custom-radio">
                                                <input class="form-check-input custom-control-input" type="radio" name="rating"
                                                    id="rating{{ $i }}" value="{{ $i }}" wire:model.live="rating">
                                                <label class="form-check-label custom-control-label" for="rating{{ $i }}">
                                                    {{ $i }} <i class="fas fa-star text-warning"></i>
                                                </label>
                                            </div>
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
                                    <button type="submit" class="btn btn-primary btn-block" wire:loading.attr="disabled">
                                        <span wire:loading.remove>{{ __('messages.submit_review_btn') }}</span>
                                        <span wire:loading><i class="fas fa-spinner fa-spin"></i> {{ __('messages.sending_btn') }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('livewire:initialized', () => {
                    @this.on('review-added', (event) => {
                        $('#reviewModal').modal('hide');
                    });
                });
            </script>

            <div class="row">
                @forelse($reviews as $review)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="testimonial-item testimonial-item-two">
                            <div class="testimonial-content">
                                <div class="rating mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p>{{ Str::limit($review->comment, 150) }}</p>
                                <div class="testimonial-avatar">
                                    <div class="avatar-thumb">
                                        <img src="{{ $review->user->avatar->url ?? asset('assets/images/users/default-user.png') }}"
                                            class="rounded-circle" alt="{{ $review->user->name ?? 'Пользователь' }}"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    </div>
                                    <div class="avatar-info">
                                        <h5 class="title">{{ $review->user->name ?? 'Пользователь' }}</h5>
                                        <span class="date">{{ $review->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                                @if($review->tour)
                                    <div class="mt-3 border-top pt-2">
                                        <small class="text-muted">Тур:</small>
                                        <a href="{{ route('tours.show', $review->tour->slug) }}" class="d-block text-primary">
                                            {{ $review->tour->title }}
                                        </a>
                                    </div>
                                @endif
                            </div>
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
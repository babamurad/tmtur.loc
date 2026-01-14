<div class="mt-5">
    <h3 class="mb-4">Отзывы ({{ $reviews->total() }})</h3>

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
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                style="width: 40px; height: 40px;">
                                {{ substr($review->user->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $review->user->name ?? 'Пользователь' }}</h6>
                                <small class="text-muted">{{ $review->created_at->format('d.m.Y H:i') }}</small>
                            </div>
                        </div>
                        <div class="text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="card-text">{{ $review->comment }}</p>
                </div>
            </div>
        @empty
            <p class="text-muted">Пока нет отзывов. Будьте первыми!</p>
        @endforelse

        {{ $reviews->links() }}
    </div>

    {{-- Форма отзыва --}}
    <div class="card bg-light mb-3">
        <div class="card-body">
            <h5 class="card-title mb-3">Оставить отзыв</h5>

            @auth
                <form wire:submit="save">
                    <div class="form-group">
                        <label>Ваша оценка:</label>
                        <div class="rating-input text-warning" style="font-size: 1.5rem; cursor: pointer;">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star"
                                    wire:click="$set('rating', {{ $i }})"></i>
                            @endfor
                        </div>
                        @error('rating') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="comment">Комментарий:</label>
                        <textarea wire:model="comment" id="comment"
                            class="form-control @error('comment') is-invalid @enderror" rows="3"
                            placeholder="Расскажите о своих впечатлениях..."></textarea>
                        @error('comment') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <span wire:loading.remove wire:target="save">Отправить отзыв</span>
                        <span wire:loading wire:target="save"><i class="fas fa-spinner fa-spin"></i> Отправка...</span>
                    </button>
                </form>
            @else
                <div class="alert alert-info mb-0">
                    Пожалуйста, <a href="{{ route('front.login') }}">авторизуйтесь</a>, чтобы оставить отзыв.
                </div>
            @endauth
        </div>
    </div>
</div>
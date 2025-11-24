<div class="container mt-5 pt-5">
    <div class="row">
        {{--  LEFT: TOUR DETAILS  --}}
        <div class="col-md-8">
            <h2 class="text-center mb-5">{{ $category->tr('title') }}</h2>
            <div class="text-center mb-1">{!! $category->tr('content') !!}</div>
            <div class="row g-4">
                @if($tours && $tours->count())
                @foreach($tours as $tour)
                    <div class="col-sm-6 mb-3">
                        <div class="card h-100 shadow">
                            <div class="position-relative">
                                <a href="{{ route('our-tours.show', $tour->slug) }}">
                                    <img src="{{ $tour->first_media_url }}"
                                         class="card-img-top" 
                                         alt="{{ $tour->tr('title') }}">
                                </a>

                            </div>

                            <div class="card-body d-flex flex-column">
                                <a href="{{ route('our-tours.show', $tour->slug) }}">
                                    <h5 class="card-title">{{ $tour->tr('title') }}</h5>
                                </a>

                                <p class="card-text small">
                                    {!! Str::words(strip_tags($tour->tr('short_description')), 20) !!}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="fw-bold text-danger">{{ $tour->tr('duration_days') }} {{ __('messages.days_label') }}</span>
                                    <span class="text-warning">
                        @for($i = 0; $i < 5; $i++)
                                            <i class="fa-solid fa-star"></i>
                        @endfor
                    </span>
                                </div>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('our-tours.show', $tour->slug) }}"
                                   class="btn btn-dark w-100">{{ __('messages.read_more') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                    {{-- пагинация --}}
                    <div class="col-12">
                        <p class="text-muted">{{ __('messages.no_tours_in_category') }}</p>
                    </div>
                @endif
            </div>
            {{ $tours->links('pagination::bootstrap-4') }}
        </div>

        {{--  RIGHT: SIDEBAR  --}}
        @livewire('front.tours-sidebar')
    </div>
</div>

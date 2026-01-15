<div class="col-md-4">
    {{--  CATEGORIES WIDGET  --}}
    <section class="section mb-5">
        <h4 class="fw-bold mt-2"><strong>{{ __('messages.categories') }}</strong></h4>
        <hr class="border-danger border-2 opacity-75">
        <ul class="list-group shadow-1-strong mt-4">
            @foreach($categories as $category)
                <li class="list-group-item list-group-item-action
                                   d-flex justify-content-between align-items-center">
                    <a href="{{ route('tours.category.show', $category->slug) }}"
                       class="text-decoration-none text-dark">
                        {{ $category->tr('title') }}
                    </a>
                    <span class="badge bg-danger rounded-pill">
                                {{ $category->tours_count }}
                            </span>
                </li>
            @endforeach
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <a class="text-decoration-none text-dark" href="{{ route('tours.category.index') }}">{{ __('messages.all_tours') }}</a>
                <span class="badge bg-danger rounded-pill">
                                {{ $totalTours }}
                        </span>
            </li>
            <!-- Запланированные туры -->
            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <a class="text-decoration-none text-dark" href="{{ route('front.tour-groups') }}">{{ __('menu.tour_groups') }}</a>
                <!-- <span class="badge bg-danger rounded-pill">
                                {{ $totalTours }}
                        </span> -->
            </li>
        </ul>
    </section>

    {{--  TAGS WIDGET  --}}
    <section class="section mb-5">
        <h4 class="fw-bold mt-2"><strong>{{ __('messages.tags') }}</strong></h4>
        <hr class="border-danger border-2 opacity-75">
        <div class="d-flex flex-wrap mt-4" style="gap: 10px;">
            @foreach($tags as $tag)
                <a href="{{ route('tours.tag.show', $tag->id) }}" class="btn btn-outline-danger btn-sm rounded-pill">
                    {{ $tag->tr('name') }} <span class="badge bg-danger text-white ms-1">{{ $tag->tours_count }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{--  POPULAR TOURS WIDGET  --}}
    <section class="section widget-content">
        <h4 class="fw-bold pt-2"><strong>{{ __('messages.popular_tours') }}</strong></h4>
        <hr class="border-danger border-2 opacity-75 mb-4">

        <div class="card card-body pb-0">
            @foreach(\App\Models\Tour::where('is_published', true)
                              ->orderBy('id','desc')
                              ->take(5)
                              ->get() as $popular)
                <div class="single-post mb-3">
                    <div class="row">
                        {{--  thumb  --}}
                        <div class="col-4">
                            <a href="{{ route('tours.show', $popular->slug) }}">
                                <img src="{{ $popular->first_media_url }}"
                                     class="img-fluid rounded"
                                     alt="{{ $popular->tr('title') }}">
                            </a>
                        </div>

                        {{--  title + date  --}}
                        <div class="col-8">
                            <h6 class="mt-0 mb-1">
                                <a href="{{ route('tours.show', $popular->slug) }}"
                                   class="text-dark">
                                    <strong>{{ \Illuminate\Support\Str::limit($popular->tr('title'), 50) }}</strong>
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="far fa-clock"></i>
                                {{ $popular->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>

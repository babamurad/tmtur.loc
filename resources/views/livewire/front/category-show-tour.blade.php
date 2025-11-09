<div class="container mt-5 pt-5">
    <div class="row">
        {{--  LEFT: TOUR DETAILS  --}}
        <div class="col-md-8">
            <h2 class="text-center mb-5">{{ $category->title }}</h2>
            <div class="row g-4">
                @if($tours && $tours->count())
                @foreach($tours as $tour)
                    <div class="col-sm-6 mb-3">
                        <div class="card h-100 shadow">
                            <div class="position-relative">
                                <a href="{{ route('our-tours.show', $tour->slug) }}">
                                    <img src="{{ $tour->media
                        ? asset('uploads/'.$tour->media->file_path)
                        : asset('assets/images/tmfotos/default.jpg') }}"
                                         class="card-img-top" alt="{{ $tour->title }}">
                                </a>

                            </div>

                            <div class="card-body d-flex flex-column">
                                <a href="{{ route('our-tours.show', $tour->slug) }}"><h5 class="card-title">{{ $tour->title }}</h5></a>

                                <p class="card-text small">
                                    {!! Str::words(strip_tags($tour->short_description), 20) !!}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="fw-bold text-danger">{{ $tour->duration_days }} days</span>
                                    <span class="text-warning">
                        @for($i = 0; $i < 5; $i++)
                                            <i class="fa-solid fa-star"></i>
                        @endfor
                    </span>
                                </div>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('our-tours.show', $tour->slug) }}"
                                   class="btn btn-dark w-100">Read more</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                    {{-- пагинация --}}
                    <div class="col-12">
                        <p class="text-muted">В данной категории нет туров.</p>
                    </div>
                @endif
            </div>
            {{ $tours->links('pagination::bootstrap-4') }}
        </div>

        {{--  RIGHT: SIDEBAR  --}}
        <div class="col-md-4">
            {{--  CATEGORIES WIDGET  --}}
            <section class="section mb-5">
                <h4 class="fw-bold mt-2"><strong>КАТЕГОРИИ</strong></h4>
                <hr class="border-danger border-2 opacity-75">
                <ul class="list-group shadow-1-strong mt-4">
                    @foreach($categories as $category)
                        <li class="list-group-item list-group-item-action
                                   d-flex justify-content-between align-items-center">
                            <a href="{{ route('tours.category.show', $category->slug) }}"
                               class="text-decoration-none text-dark">
                                {{ $category->title }}
                            </a>
                            <span class="badge bg-danger rounded-pill">
                                {{ $category->tours->count() ?? 0 }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </section>

            {{--  POPULAR TOURS WIDGET  --}}
            <section class="section widget-content">
                <h4 class="fw-bold pt-2"><strong>ПОПУЛЯРНЫЕ ТУРЫ</strong></h4>
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
                                    <a href="{{ route('our-tours.show', $popular->slug) }}">
                                        <img src="{{ $popular->media
                                                ? asset('uploads/'.$popular->media->file_path)
                                                : asset('assets/images/tmfotos/default.jpg') }}"
                                             class="img-fluid rounded"
                                             alt="{{ $popular->title }}">
                                    </a>
                                </div>

                                {{--  title + date  --}}
                                <div class="col-8">
                                    <h6 class="mt-0 mb-1">
                                        <a href="{{ route('our-tours.show', $popular->slug) }}"
                                           class="text-dark">
                                            <strong>{{ \Illuminate\Support\Str::limit($popular->title, 50) }}</strong>
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
    </div>
</div>

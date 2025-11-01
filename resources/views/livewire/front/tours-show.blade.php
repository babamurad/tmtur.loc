{{-- resources/views/tours/show.blade.php --}}
<div class="container mt-5 pt-5">
    <div class="row">
        {{--  LEFT: TOUR DETAILS  --}}
        <div class="col-md-8">
            <div class="card mb-4">
                {{--  HEADER IMAGE  --}}
                @if($tour->media)
                    <img src="{{ asset('uploads/'.$tour->media->file_path) }}"
                         class="card-img-top"
                         alt="{{ $tour->title }}">
                @else
                    <img src="{{ asset('assets/images/tmfotos/default.jpg') }}"
                         class="card-img-top"
                         alt="{{ $tour->title }}">
                @endif

                <div class="card-body">
                    {{--  TITLE  --}}
                    <h1 class="card-title mb-3">{{ $tour->title }}</h1>

                    {{--  SHORT DESCRIPTION  --}}
                    <div class="card-text mb-3">
                        {!! $tour->short_description !!}
                    </div>
                </div>

                {{--  FOOTER (meta)  --}}
                <div class="card-footer text-muted">
                    Категория:
                    <a href="#">
                        {{ $tour->category->title }}
                    </a>
                    <span class="float-end">
                        <i class="far fa-calendar"></i>
                        {{ $tour->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            {{--  BOOKING FORM (Livewire component)  --}}
{{--            @livewire('front.tour-booking', ['tour' => $tour], key($tour->id))--}}
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
                            <a href="#"
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

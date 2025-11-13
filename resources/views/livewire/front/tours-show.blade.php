<div class="container mt-5 pt-5">
    <div class="row">
        {{--  LEFT: TOUR DETAILS  --}}
        <div class="col-md-8">
            {{--  ОБЁРТКА  --}}
            <div class="card shadow-sm mb-4">
                {{--  КАРТИНКА  --}}
                @if($tour->media)
                    <img src="{{ asset('uploads/'.$tour->media->file_path) }}"
                         class="card-img-top" alt="{{ $tour->title }}">
                @else
                    <img src="{{ asset('assets/images/tmfotos/default.jpg') }}"
                         class="card-img-top" alt="{{ $tour->title }}">
                @endif

                {{--  ТЕЛО  --}}
                <div class="card-body">
                    {{--  ЗАГОЛОВОК  --}}
                    <h1 class="card-title mb-3">{{ $tour->title }}</h1>

                    {{--  КОРОТКОЕ ОПИСАНИЕ  --}}
                    <div class="mb-4">
                        {!! $tour->short_description !!}
                    </div>

                    {{--  СЕТКА ИНФО-ПЛИТОК  --}}
                    <div class="row text-center mb-3">
                        {{--  ДНИ  --}}
                        <div class="col-4">
                            <div class="border rounded py-3">
                                <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                                <div class="h5 mb-0">
                                    {{ $tour->itineraryDays ? $tour->itineraryDays->count() : 0 }}
                                </div>
                                <small class="text-muted">дней</small>
                            </div>
                        </div>

                        {{--  ГРУППЫ  --}}
                        <div class="col-4">
                            <div class="border rounded py-3">
                                <i class="fas fa-users fa-2x text-info mb-2"></i>
                                <div class="h5 mb-0">
                                    {{ $tour->groupsOpen ? $tour->groupsOpen->count() : 0 }}
                                </div>
                                <small class="text-muted">групп</small>
                            </div>
                        </div>

                        {{--  РАЗМЕЩЕНИЕ  --}}
                        <div class="col-4">
                            <div class="border rounded py-3">
                                <i class="fas fa-bed fa-2x text-warning mb-2"></i>
                                <div class="h5 mb-0">
                                    {{ $tour->accommodations ? $tour->accommodations->count() : 0 }}
                                </div>
                                <small class="text-muted">вариантов</small>
                            </div>
                        </div>
                    </div>

{{--                    <i class="fas fa-times-circle text-danger mr-2"></i>

--}}
                    {{--  БЛОК «ВКЛЮЧЕНО / НЕ ВКЛЮЧЕНО»  --}}
                    @if($tour->inclusions && $tour->inclusions->count())
                        <div class="row text-center mb-3">
                            <div class="col-sm-6">
                                <h6 class="text-uppercase text-muted mb-2 text-left">Что включено</h6>
                                <ul class="list-unstyled text-left">
                                    @foreach($tour->inclusions as $item)
                                        <li class="mb-2">
                                            @if($item->type === 'included')
                                                <i class="fas fa-check-circle text-success mr-2"></i>
                                                {{ $item->item }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-uppercase text-muted mb-2 text-left">Что не включено</h6>
                                <ul class="list-unstyled text-left">
                                    @foreach($tour->inclusions as $item)
                                        <li class="mb-2">
                                            @if($item->type === 'not_included')
                                                <i class="fas fa-times-circle text-danger mr-2"></i>
                                                {{ $item->item }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <ul>
                        @foreach($tour->itineraryDays as $day)
                            <li>
                                <p>{{ $day->day_number }}</p>
                                <p>{{ $day->title }}</p>
                                <p>{{ $day->description }}</p>
                            </li>
                        @endforeach
                    </ul>

                </div>

                {{--  ФУТЕР  --}}
                <div class="card-footer bg-light text-muted d-flex justify-content-between">
        <span>
            Категория:
{{--            {{ route('tours.category', $tour->category->slug) }}--}}

                @forelse ($tour->categories as $category)
                    <span class="badge badge-pill badge-primary text-white">
                        <a href="{{ route('tours.category.show', $category->slug) }}">{{ $category->title }}</a>
                    </span>
                @empty
                    N/A
                @endforelse

        </span>
                    <span>
            <i class="far fa-calendar mr-1"></i>
            {{ $tour->created_at->diffForHumans() }}
        </span>
                </div>
            </div>

            {{--  BOOKING FORM (Livewire component)  --}}
{{--            @livewire('front.tour-booking', ['tour' => $tour], key($tour->id))--}}
        </div>

        {{--  RIGHT: SIDEBAR  --}}
        @livewire('front.tours-sidebar')
    </div>
</div>

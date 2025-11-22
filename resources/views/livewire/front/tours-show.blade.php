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
                    <h1 class="card-title mb-3">{{ $tour->tr('title') }}</h1>

                    {{--  КОРОТКОЕ ОПИСАНИЕ  --}}
                    <div class="mb-4 short_description">
                        {!! $tour->tr('short_description') !!}
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
                                <small class="text-muted">{{ __('messages.days_label') }}</small>
                            </div>
                        </div>

                        {{--  ГРУППЫ  --}}
                        <div class="col-4">
                            <div class="border rounded py-3">
                                <i class="fas fa-users fa-2x text-info mb-2"></i>
                                <div class="h5 mb-0">
                                    {{ $tour->groupsOpen ? $tour->groupsOpen->count() : 0 }}
                                </div>
                                <small class="text-muted">{{ __('messages.groups') }}</small>
                            </div>
                        </div>

                        {{--  РАЗМЕЩЕНИЕ  --}}
                        <div class="col-4">
                            <div class="border rounded py-3">
                                <i class="fas fa-bed fa-2x text-warning mb-2"></i>
                                <div class="h5 mb-0">
                                    {{ $tour->accommodations ? $tour->accommodations->count() : 0 }}
                                </div>
                                <small class="text-muted">{{ __('messages.options') }}</small>
                            </div>
                        </div>
                    </div>

{{--                    <i class="fas fa-times-circle text-danger mr-2"></i>

--}}
                    {{--  БЛОК «ВКЛЮЧЕНО / НЕ ВКЛЮЧЕНО»  --}}
                    @if($tour->inclusions && $tour->inclusions->count())
                        <div class="row text-center mb-3">
                            <div class="col-sm-6">
                                <h6 class="text-uppercase text-muted mb-2 text-left">{{ __('messages.what_is_included') }}</h6>
                                <ul class="list-unstyled text-left">
                                    @foreach($tour->inclusions as $item)
                                        <li class="mb-2">
                                            @if($item->type === 'included')
                                                <i class="fas fa-check-circle text-success mr-2"></i>
                                                {{ $item->tr('item') }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-uppercase text-muted mb-2 text-left">{{ __('messages.what_is_not_included') }}</h6>
                                <ul class="list-unstyled text-left">
                                    @foreach($tour->inclusions as $item)
                                        <li class="mb-2">
                                            @if($item->type === 'not_included')
                                                <i class="fas fa-times-circle text-danger mr-2"></i>
                                                {{ $item->tr('item') }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- Программа тура --}}

                    <div class="card-header my-4">
                    <h5>{{ __('messages.tour_program') }}</h5>
                    </div>
                    <div class="accordion" id="itineraryAccordion">
                        @foreach($tour->itineraryDays as $idx => $day)
                            <div class="card">
                                {{-- заголовок панели --}}
                                <div class="card-header p-0" id="heading{{ $idx }}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left d-flex justify-content-between align-items-center
                                   text-decoration-none text-dark"
                                                type="button"
                                                data-toggle="collapse"
                                                data-target="#collapse{{ $idx }}"
                                                aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $idx }}">
                                            <span class="badge badge-light">{{ __('messages.day') }} {{ $day->day_number }}</span>
                                            <span class="font-weight-normal ">{{ $day->tr('title') }}</span>
                                        </button>
                                    </h2>
                                </div>

                                {{-- тело панели --}}
                                <div id="collapse{{ $idx }}"
                                     class="collapse {{ $idx === 0 ? 'show' : '' }}"
                                     aria-labelledby="heading{{ $idx }}"
                                     data-parent="#itineraryAccordion">
                                    <div class="card-body">
                                        {!! nl2br(e($day->tr('description'))) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

{{--                    accommodations--}}

                        <div class="card-header mt-4">
                            <h5 class="mb-0">{{ __('messages.accommodations') }}</h5>
                        </div>

                    @if($tour->accommodations)
                        <ul>
                            @foreach($tour->accommodations as $accommodation)
                                <li>
                                    {{ $accommodation->tr('location') }} ({{ $accommodation->nights_count }} {{ __('messages.nights') }})
                                    @if($accommodation->tr('standard_options'))
                                        <br><small class="text-muted">{{ __('messages.standard') }}: {{ $accommodation->tr('standard_options') }}</small>
                                    @endif
                                    @if($accommodation->tr('comfort_options'))
                                        <br><small class="text-muted">{{ __('messages.comfort') }}: {{ $accommodation->tr('comfort_options') }}</small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{--  ФУТЕР  --}}
                <div class="card-footer bg-light text-muted d-flex justify-content-between">
        <span>
            {{ __('messages.category') }}:
{{--            {{ route('tours.category', $tour->category->slug) }}--}}

                @forelse ($tour->categories as $category)
                    <span class="badge badge-pill badge-primary text-white">
                        <a href="{{ route('tours.category.show', $category->slug) }}">{{ $category->tr('title') }}</a>
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

<div class="container mt-5 pt-5">
    <div class="row">
        {{--  LEFT: TOUR DETAILS  --}}
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                {{-- ГАЛЕРЕЯ ИЗОБРАЖЕНИЙ --}}
                @if($tour->orderedMedia && $tour->orderedMedia->count() > 0)
                    {{-- Главное изображение --}}
                    <div class="position-relative">
                        <img src="{{ asset('uploads/' . $tour->orderedMedia->first()->file_path) }}"
                             class="card-img-top"
                             alt="{{ $tour->tr('title') }}"
                             style="max-height: 500px; object-fit: cover; cursor: pointer;"
                             data-toggle="modal"
                             data-target="#galleryModal">
                        
                        @if($tour->orderedMedia->count() > 1)
                            <div class="position-absolute" style="bottom: 15px; right: 15px;">
                                <span class="badge badge-dark badge-pill px-3 py-2">
                                    <i class="fas fa-images"></i> {{ $tour->orderedMedia->count() }} {{ __('messages.photos') ?? 'фото' }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Миниатюры галереи --}}
                    @if($tour->orderedMedia->count() > 1)
                        <div class="card-body pb-2">
                            <div class="row g-2">
                                @foreach($tour->orderedMedia->take(6) as $index => $media)
                                    <div class="col-2">
                                        <img src="{{ asset('uploads/' . $media->file_path) }}"
                                             class="img-thumbnail {{ $index === 0 ? 'border-primary' : '' }}"
                                             alt="{{ $tour->tr('title') }}"
                                             style="height: 60px; object-fit: cover; cursor: pointer; width: 100%;"
                                             data-toggle="modal"
                                             data-target="#galleryModal"
                                             onclick="showGalleryImage({{ $index }})">
                                    </div>
                                @endforeach
                                
                                @if($tour->orderedMedia->count() > 6)
                                    <div class="col-2">
                                        <div class="img-thumbnail d-flex align-items-center justify-content-center bg-light"
                                             style="height: 60px; cursor: pointer;"
                                             data-toggle="modal"
                                             data-target="#galleryModal"
                                             onclick="showGalleryImage(6)">
                                            <span class="text-muted">+{{ $tour->orderedMedia->count() - 6 }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    {{-- Изображение по умолчанию --}}
                    <img src="{{ asset('assets/images/tmfotos/default.jpg') }}"
                         class="card-img-top" alt="{{ $tour->tr('title') }}">
                @endif

                {{-- ТЕЛО --}}
                <div class="card-body">
                    {{-- ЗАГОЛОВОК --}}
                    <h1 class="card-title mb-3">{{ $tour->tr('title') }}</h1>

                    {{-- КОРОТКОЕ ОПИСАНИЕ --}}
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

            {{-- BOOKING FORM (Livewire component) --}}
{{--            @livewire('front.tour-booking', ['tour' => $tour], key($tour->id))--}}
        </div>

        {{-- RIGHT: SIDEBAR --}}
        @livewire('front.tours-sidebar')
    </div>

    {{-- GALLERY MODAL --}}
    @if($tour->orderedMedia && $tour->orderedMedia->count() > 0)
        <div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-white" id="galleryModalLabel">
                            <i class="fas fa-images"></i> {{ $tour->tr('title') }}
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div id="galleryCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                            {{-- Indicators --}}
                            <ol class="carousel-indicators">
                                @foreach($tour->orderedMedia as $index => $media)
                                    <li data-target="#galleryCarousel" 
                                        data-slide-to="{{ $index }}" 
                                        class="{{ $index === 0 ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>

                            {{-- Slides --}}
                            <div class="carousel-inner">
                                @foreach($tour->orderedMedia as $index => $media)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('uploads/' . $media->file_path) }}" 
                                             class="d-block w-100" 
                                             alt="{{ $media->file_name }}"
                                             style="max-height: 80vh; object-fit: contain;">
                                        @if($media->file_name)
                                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                                                <p class="mb-0">{{ $media->file_name }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            {{-- Controls --}}
                            @if($tour->orderedMedia->count() > 1)
                                <a class="carousel-control-prev" href="#galleryCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#galleryCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer border-0 justify-content-center">
                        <span class="text-white">
                            <i class="fas fa-image"></i> 
                            <span id="currentImageNumber">1</span> / {{ $tour->orderedMedia->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gallery JavaScript --}}
        @push('scripts')
        <script>
            function showGalleryImage(index) {
                $('#galleryCarousel').carousel(index);
            }

            $(document).ready(function() {
                // Update image counter when carousel slides
                $('#galleryCarousel').on('slid.bs.carousel', function (e) {
                    var currentIndex = $('div.carousel-item.active').index() + 1;
                    $('#currentImageNumber').text(currentIndex);
                });

                // Keyboard navigation
                $('#galleryModal').on('shown.bs.modal', function() {
                    $(document).on('keydown.gallery', function(e) {
                        if (e.keyCode == 37) { // Left arrow
                            $('#galleryCarousel').carousel('prev');
                        } else if (e.keyCode == 39) { // Right arrow
                            $('#galleryCarousel').carousel('next');
                        } else if (e.keyCode == 27) { // Escape
                            $('#galleryModal').modal('hide');
                        }
                    });
                });

                $('#galleryModal').on('hidden.bs.modal', function() {
                    $(document).off('keydown.gallery');
                });
            });
        </script>
        @endpush
    @endif
</div>

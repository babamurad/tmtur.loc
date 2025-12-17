<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('menu.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tours.category.index') }}">{{ __('menu.tours') }}</a></li>
                <li class="breadcrumb-item active">{{ $tour->tr('title') }}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        {{-- LEFT: TOUR DETAILS --}}
        <div class="col-md-8">


    {{-- модалка --}}
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.modal_book_tour_title') }}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <p class="text-muted text-center">{{ __('messages.modal_book_tour_description') }}</p>
                <form>
                {{-- honeypot --}}
                <div style="position:absolute; left:-9999px;">
                    <input type="text" wire:model.defer="hp" tabindex="-1">
                </div>

                <div class="form-group">
                    <input class="form-control @error('name') is-invalid @enderror"
                        wire:model.defer="name" placeholder="{{ __('messages.modal_name_placeholder') }}">
                    @error('name') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        wire:model.defer="email" placeholder="Email">
                    @error('email') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                        wire:model.defer="phone" placeholder="{{ __('messages.modal_phone_placeholder') }}">
                    @error('phone') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <textarea class="form-control @error('message') is-invalid @enderror"
                            wire:model.defer="message" rows="4" placeholder="{{ __('messages.modal_message_placeholder') }}"></textarea>
                    @error('message') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.modal_cancel_button') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="sendMessage()">{{ __('messages.modal_send_button') }}</button>
                </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', () => {
                $('#exampleModal').modal('hide');
            });
        });
    </script>


            {{-- КАРТОЧКА ТУРА --}}

            <div class="card shadow-sm mb-4">
                {{-- ГАЛЕРЕЯ ИЗОБРАЖЕНИЙ --}}
                @if($tour->orderedMedia && $tour->orderedMedia->count() > 0)
                    {{-- Главное изображение --}}
                    <div class="position-relative">
                        <img src="{{ asset('uploads/' . $tour->orderedMedia->first()->file_path) }}" class="card-img-top"
                            alt="{{ $tour->tr('title') }}" style="max-height: 500px; object-fit: cover; cursor: pointer;"
                            data-toggle="modal" data-target="#galleryModal">

                        @if($tour->orderedMedia->count() > 1)
                            <div class="position-absolute" style="bottom: 15px; right: 15px;">
                                <span class="badge badge-dark badge-pill px-3 py-2">
                                    <i class="fas fa-images"></i> {{ $tour->orderedMedia->count() }}
                                    {{ __('messages.photos') ?? 'фото' }}
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
                                            data-toggle="modal" data-target="#galleryModal"
                                            onclick="showGalleryImage({{ $index }})">
                                    </div>
                                @endforeach

                                @if($tour->orderedMedia->count() > 6)
                                    <div class="col-2">
                                        <div class="img-thumbnail d-flex align-items-center justify-content-center bg-light"
                                            style="height: 60px; cursor: pointer;" data-toggle="modal" data-target="#galleryModal"
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
                    <img src="{{ asset('assets/images/tmfotos/default.jpg') }}" class="card-img-top"
                        alt="{{ $tour->tr('title') }}">
                @endif

                {{-- ТЕЛО --}}
                <div class="card-body">
                    {{-- ЗАГОЛОВОК --}}
                    <h1 class="card-title mb-3">{{ $tour->tr('title') }}</h1>

                    {{-- КОРОТКОЕ ОПИСАНИЕ --}}
                    <div class="mb-4 short_description">
                        {!! $tour->tr('short_description') !!}
                    </div>

                    {{-- СЕТКА ИНФО-ПЛИТОК --}}
                    <div class="row text-center mb-3">
                        {{-- ДНИ --}}
                        <div class="col-4">
                            <div class="border rounded py-3">
                                <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                                <div class="h5 mb-0">
                                    {{ $tour->itineraryDays ? $tour->itineraryDays->count() : 0 }}
                                </div>
                                <small class="text-muted">{{ __('messages.days_label') }}</small>
                            </div>
                        </div>

                        {{-- ГРУППЫ --}}
                        <div class="col-4">
                            <div class="border rounded py-3">
                                <i class="fas fa-users fa-2x text-info mb-2"></i>
                                <div class="h5 mb-0">
                                    {{ $this->totalOpenGroupsCount }}
                                </div>
                                <small class="text-muted">{{ __('messages.groups') }}</small>
                            </div>
                        </div>

                        {{-- РАЗМЕЩЕНИЕ --}}
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

                    {{-- ДОСТУПНЫЕ ГРУППЫ И ДАТЫ --}}
                    @if($tour->groupsOpen && $tour->groupsOpen->count() > 0)
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-calendar-check"></i>
                                    {{ __('messages.available_dates') ?? 'Доступные даты отправления' }}
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @foreach($tour->groupsOpen as $group)
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                {{-- Дата отправления --}}
                                                <div class="col-md-3 mb-2 mb-md-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                                        <div>
                                                            <strong
                                                                class="d-block">{{ \Carbon\Carbon::parse($group->starts_at)->format('d.m.Y') }}</strong>
                                                            <small
                                                                class="text-muted">{{ \Carbon\Carbon::parse($group->starts_at)->format('H:i') }}</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Свободные места --}}
                                                <div class="col-md-2 mb-2 mb-md-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-users text-info mr-2"></i>
                                                        <div>
                                                            @php
                                                                $available = $group->max_people - $group->current_people;
                                                                $percentage = ($available / $group->max_people) * 100;
                                                            @endphp
                                                            <span
                                                                class="badge badge-{{ $percentage > 50 ? 'success' : ($percentage > 20 ? 'warning' : 'danger') }}">
                                                                {{ $available }} / {{ $group->max_people }}
                                                                {{ __('messages.seats') ?? 'мест' }}
                                                            </span>
                                                            <small
                                                                class="d-block text-muted">{{ __('messages.available') ?? 'свободно' }}</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Цена --}}
                                                <div class="col-md-3 mb-2 mb-md-0">
                                                    <div class="d-flex flex-column">

                                                        {{-- 2 Prices Display --}}
                                                        @if($group->max_people > 1)
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="badge bg-secondary border border-secondary text-secondary mb-1 font-weight-normal text-left"
                                                                    style="background-color: #f8f9fa;">
                                                                    <i class="fas fa-user"></i> 1
                                                                    {{ __('messages.person') ?? 'чел.' }}:
                                                                    <strong>${{ $group->price_max }}</strong>
                                                                </span>
                                                                <span
                                                                    class="badge bg-success border border-success text-success mb-1 font-weight-normal text-left"
                                                                    style="background-color: #f8fff9;">
                                                                    <i class="fas fa-users"></i> {{ $group->max_people }}
                                                                    {{ __('messages.people') ?? 'чел.' }}:
                                                                    <strong>${{ $group->price_min }}</strong>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Кнопка бронирования --}}
                                                <div class="col-md-4">
                                                    @if($available > 0)
                                                        <button type="button" href="#" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                                                            <i class="fas fa-ticket-alt mr-1"></i>
                                                            {{ __('messages.book_now') ?? 'Забронировать' }}
                                                        </button>
                                                    @else
                                                        <button class="btn btn-secondary btn-block" disabled>
                                                            <i class="fas fa-times-circle mr-1"></i>
                                                            {{ __('messages.sold_out') ?? 'Мест нет' }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer text-muted small">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-info-circle"></i>
                                        {{ __('messages.booking_info') ?? 'Выберите удобную дату и забронируйте место в группе' }}
                                    </div>
                                    @if($this->totalOpenGroupsCount > 3)
                                        <a href="{{ route('front.tour-groups') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            {{ __('messages.view_all_dates') ?? 'Смотреть все даты' }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            {{ __('messages.no_available_groups') ?? 'В данный момент нет доступных дат для этого тура. Свяжитесь с нами для индивидуального тура.' }}
                        </div>
                    @endif

                    {{-- БЛОК «ВКЛЮЧЕНО / НЕ ВКЛЮЧЕНО» --}}
                    @if($tour->inclusions && $tour->inclusions->count())
                        <div class="accordion" id="accordionInclusions">
                            <div class="card">
                                <div class="card-header p-0" id="headingInclusions">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseInclusions" aria-expanded="true" aria-controls="collapseInclusions">
                                            <h6 class="mb-0">{{ __('messages.what_is_included_not_included') }}</h6>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseInclusions" class="collapse show" aria-labelledby="headingInclusions" data-parent="#accordionInclusions">
                                    <div class="card-body">
                                        <div class="row text-center mb-3">
                                            <div class="col-sm-6">
                                                <h6 class="text-uppercase text-muted mb-2 text-left">{{ __('messages.what_is_included') }}
                                                </h6>
                                                <ul class="list-unstyled text-left">
                                                    @foreach($tour->inclusions as $item)
                                                        @if($item->pivot->is_included)
                                                            <li class="mb-2">
                                                                <i class="fas fa-check-circle text-success mr-2"></i>
                                                                {{ $item->tr('title') }}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-sm-6">
                                                <h6 class="text-uppercase text-muted mb-2 text-left">
                                                    {{ __('messages.what_is_not_included') }}
                                                </h6>
                                                <ul class="list-unstyled text-left">
                                                    @foreach($tour->inclusions as $item)
                                                        @if(!$item->pivot->is_included)
                                                            <li class="mb-2">
                                                                <i class="fas fa-times-circle text-danger mr-2"></i>
                                                                {{ $item->tr('title') }}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                           text-decoration-none text-dark" type="button" data-toggle="collapse"
                                            data-target="#collapse{{ $idx }}"
                                            aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}"
                                            aria-controls="collapse{{ $idx }}">
                                            <span class="badge badge-light">{{ __('messages.day') }}
                                                {{ $day->day_number }}</span>
                                            <span class="font-weight-normal ">{{ $day->tr('title') }}</span>
                                        </button>
                                    </h2>
                                </div>

                                {{-- тело панели --}}
                                <div id="collapse{{ $idx }}" class="collapse {{ $idx === 0 ? 'show' : '' }}"
                                    aria-labelledby="heading{{ $idx }}" data-parent="#itineraryAccordion">
                                    <div class="card-body">
                                        {!! nl2br(e($day->tr('description'))) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- accommodations--}}

                    <div class="card-header mt-4">
                        <h5 class="mb-0">{{ __('messages.accommodations') }}</h5>
                    </div>

                    @if($tour->accommodations)
                        <ul>
                            @foreach($tour->accommodations as $accommodation)
                                <li>
                                    {{ $accommodation->tr('location') }} ({{ $accommodation->nights_count }}
                                    {{ __('messages.nights') }})
                                    @if($accommodation->tr('standard_options'))
                                        <br><small class="text-muted">{{ __('messages.standard') }}:
                                            {{ $accommodation->tr('standard_options') }}</small>
                                    @endif
                                    @if($accommodation->tr('comfort_options'))
                                        <br><small class="text-muted">{{ __('messages.comfort') }}:
                                            {{ $accommodation->tr('comfort_options') }}</small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- ФУТЕР --}}
                <div class="card-footer bg-light text-muted d-flex justify-content-between">
                    <span>
                        {{ __('messages.category') }}:
                        {{-- {{ route('tours.category', $tour->category->slug) }}--}}

                        @forelse ($tour->categories as $category)
                            <span class="badge badge-pill badge-primary text-white">
                                <a class="tour-category-link"
                                    href="{{ route('tours.category.show', $category->slug) }}">{{ $category->tr('title') }}</a>
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
            {{-- @livewire('front.tour-booking', ['tour' => $tour], key($tour->id))--}}
        </div>

        {{-- RIGHT: SIDEBAR --}}
        @livewire('front.tours-sidebar')
    </div>

    {{-- GALLERY MODAL --}}
    @if($tour->orderedMedia && $tour->orderedMedia->count() > 0)
        <div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="galleryModalLabel"
            aria-hidden="true">
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
                                    <li data-target="#galleryCarousel" data-slide-to="{{ $index }}"
                                        class="{{ $index === 0 ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>

                            {{-- Slides --}}
                            <div class="carousel-inner">
                                @foreach($tour->orderedMedia as $index => $media)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('uploads/' . $media->file_path) }}" class="d-block w-100"
                                            alt="{{ $media->file_name }}" style="max-height: 80vh; object-fit: contain;">
                                        <!-- @if($media->file_name)
                                                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                                                                <p class="mb-0">{{ $media->file_name }}</p>
                                                            </div>
                                                        @endif -->
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

                $(document).ready(function () {
                    // Update image counter when carousel slides
                    $('#galleryCarousel').on('slid.bs.carousel', function (e) {
                        var currentIndex = $('div.carousel-item.active').index() + 1;
                        $('#currentImageNumber').text(currentIndex);
                    });

                    // Keyboard navigation
                    $('#galleryModal').on('shown.bs.modal', function () {
                        $(document).on('keydown.gallery', function (e) {
                            if (e.keyCode == 37) { // Left arrow
                                $('#galleryCarousel').carousel('prev');
                            } else if (e.keyCode == 39) { // Right arrow
                                $('#galleryCarousel').carousel('next');
                            } else if (e.keyCode == 27) { // Escape
                                $('#galleryModal').modal('hide');
                            }
                        });
                    });

                    $('#galleryModal').on('hidden.bs.modal', function () {
                        $(document).off('keydown.gallery');
                    });
                });
            </script>
        @endpush
    @endif
</div>
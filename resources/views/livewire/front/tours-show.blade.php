<div class="container mt-5">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('menu.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tours.category.index') }}">{{ __('menu.tours') }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $tour->tr('title') }}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        {{-- LEFT: TOUR DETAILS --}}
        <div class="col-md-8">

            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif


            {{-- Booking modal --}}
            @if($showBookingModal)
                <div class="modal fade show d-block tm-modal" tabindex="-1" role="dialog" aria-modal="true"
                    style="background: rgba(0,0,0,0.55);">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">

                            <div class="tm-modal-header">
                                <button type="button" class="close tm-modal-close" aria-label="Close"
                                    wire:click="closeBookingModal">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                                <div class="d-flex align-items-center">
                                    <div class="tm-icon-circle">
                                        ✉
                                    </div>
                                    <div>
                                        <h5 class="mb-0">
                                            {{ __('messages.modal_booking_title') }}
                                        </h5>
                                        <p class="mb-0">
                                            {{ __('Leave your contacts and we will confirm availability for this group.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if($bookingSuccess)
                                <div class="tm-modal-body">
                                    <div class="text-center py-5">
                                        <div class="mb-3 text-success">
                                            <i class="fas fa-check-circle fa-4x"></i>
                                        </div>
                                        <h5 class="mb-3">{{ __('messages.booking_request_sent_successfully') }}</h5>
                                        <p class="text-muted">{{ __('messages.we_will_contact_you_soon') ?? 'Мы свяжемся с вами в ближайшее время.' }}</p>
                                        <button type="button" class="btn btn-secondary mt-3" wire:click="closeBookingModal">
                                            {{ __('messages.close') }}
                                        </button>
                                    </div>
                                </div>
                            @else
                                <form wire:submit.prevent="submitBooking" novalidate
                                    class="d-flex flex-column flex-grow-1 overflow-auto">
                                {{-- Honeypot: скрытое поле для ловли ботов --}}
                                <div
                                    style="position:absolute; left:-9999px; top:auto; width:1px; height:1px; overflow:hidden;">
                                    <label>Leave this field empty</label>
                                    <input type="text" wire:model.defer="hp" tabindex="-1" autocomplete="off">
                                </div>

                                <div class="tm-modal-body">
                                    @if($selectedGroup)
                                        <div class="tm-tour-summary">
                                            <div class="tm-tour-summary-title">
                                                {{ $tour->tr('title') }}
                                            </div>
                                            <div class="tm-tour-summary-meta">
                                                <span>
                                                    <i class="far fa-calendar-alt"></i>
                                                    @if($selectedGroup->starts_at)
                                                        {{ \Carbon\Carbon::parse($selectedGroup->starts_at)->format('d.m.Y') }}
                                                    @endif
                                                </span>

                                                @php
                                                    $available = max(0, (int) $selectedGroup->freePlaces());
                                                    $capacity = (int) $selectedGroup->max_people;
                                                    $booked = max(0, $capacity - $available);
                                                @endphp

                                                <span>
                                                    <i class="fas fa-user-check"></i>
                                                    {{ $booked }} / {{ $capacity }} {{ __('messages.booked_badge') }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-user-plus"></i>
                                                    {{ __('messages.available_seats_badge') }}: {{ $available }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="booking_name" class="tm-form-label">
                                                {{ __('messages.modal_name_label') }}
                                            </label>
                                            <input type="text" id="booking_name"
                                                class="form-control tm-form-control @error('booking_name') is-invalid @enderror"
                                                wire:model="booking_name">
                                            @error('booking_name')
                                                <div class="tm-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="booking_email" class="tm-form-label">
                                                {{ __('messages.modal_email_label') }}
                                            </label>
                                            <input type="email" id="booking_email"
                                                class="form-control tm-form-control @error('booking_email') is-invalid @enderror"
                                                wire:model="booking_email">
                                            @error('booking_email')
                                                <div class="tm-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="booking_phone" class="tm-form-label">
                                                {{ __('messages.modal_phone_label') }}
                                            </label>
                                            <input type="text" id="booking_phone"
                                                class="form-control tm-form-control @error('booking_phone') is-invalid @enderror"
                                                wire:model="booking_phone">
                                            @error('booking_phone')
                                                <div class="tm-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="booking_guests" class="tm-form-label">
                                                {{ __('messages.modal_guests_label') }}
                                            </label>
                                            <input type="number" min="1" id="booking_guests"
                                                class="form-control tm-form-control @error('booking_guests') is-invalid @enderror"
                                                wire:model="booking_guests">
                                            @error('booking_guests')
                                                <div class="tm-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="booking_message" class="tm-form-label">
                                            {{ __('messages.modal_message_label') }}
                                        </label>
                                        <textarea id="booking_message" rows="3"
                                            class="form-control tm-form-control tm-textarea @error('booking_message') is-invalid @enderror"
                                            wire:model="booking_message"></textarea>
                                        @error('booking_message')
                                            <div class="tm-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-muted small mt-2">
                                        {!! __('messages.agree_terms_order', ['terms_url' => route('terms'), 'privacy_url' => route('privacy')]) !!}
                                    </div>


                                    @error('booking_general')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <button type="button" class="btn btn-secondary" wire:click="closeBookingModal">
                                            {{ __('Cancel') }}
                                        </button>

                                        <button type="submit" class="btn tm-order-btn text-white"
                                            wire:loading.attr="disabled">
                                            <span wire:loading.remove>{{ __('Send') }}</span>
                                            <span wire:loading>{{ __('Sending...') }}</span>
                                        </button>
                                    </div>
                                </div>
                                </form>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show"></div>
            @endif


            {{-- КАРТОЧКА ТУРА --}}

            <div class="card shadow-sm mb-4">
                {{-- ГАЛЕРЕЯ ИЗОБРАЖЕНИЙ --}}
                @if($tour->orderedMedia && $tour->orderedMedia->count() > 0)
                    {{-- Главное изображение --}}
                    <div class="position-relative">
                        <img src="{{ asset('uploads/' . $tour->orderedMedia->first()->file_path) }}"
                            class="card-img-top img-fluid" <img
                            src="{{ asset('uploads/' . $tour->orderedMedia->first()->file_path) }}"
                            class="card-img-top img-fluid" alt="{{ $tour->tr('title') }}"
                            style="max-height: 500px; object-fit: cover; cursor: pointer;" data-toggle="modal"
                            data-target="#galleryModal">

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
                    <style>
                        .short_description img {
                            max-width: 100%;
                            height: auto;
                        }
                    </style>
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
                                    @php
                                        $firstThreeGroups = $tour->groupsOpen->take(3);
                                        $remainingGroups = $tour->groupsOpen->slice(3);
                                    @endphp

                                    {{-- Первые 3 группы - всегда видимые --}}
                                    @foreach($firstThreeGroups as $group)
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
                                                        <button type="button" href="#" class="btn btn-sm btn-primary btn-block"
                                                            wire:click.prevent="openBookingModal({{ $group->id }})">
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

                                    {{-- Остальные группы - скрытые, раскрываются по клику --}}
                                    @if($remainingGroups->count() > 0)
                                        <div class="collapse" id="moreGroupDates">
                                            @foreach($remainingGroups as $group)
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
                                                                <button type="button" href="#" class="btn btn-sm btn-primary btn-block"
                                                                    wire:click.prevent="openBookingModal({{ $group->id }})">
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
                                    @endif
                                </div>
                            </div>
                            @if($tour->groupsOpen->count() > 3)
                                <div class="card-footer text-center p-0 m-0">
                                    <button class="btn btn-link text-primary m-1 p-2" type="button" data-toggle="collapse"
                                        data-target="#moreGroupDates" aria-expanded="false" aria-controls="moreGroupDates">
                                        <span class="when-collapsed">
                                            {{ __('messages.view_all_dates') ?? 'Смотреть все даты' }}
                                            <i class="fas fa-chevron-down ml-1"></i>
                                        </span>
                                        <span class="when-expanded" style="display: none;">
                                            {{ __('messages.hide_dates') ?? 'Скрыть' }}
                                            <i class="fas fa-chevron-up ml-1"></i>
                                        </span>
                                    </button>
                                </div>
                            @endif
                            <div class="card-footer text-muted small">
                                <i class="fas fa-info-circle"></i>
                                {{ __('messages.booking_info') ?? 'Выберите удобную дату и забронируйте место в группе' }}
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
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapseInclusions" aria-expanded="false"
                                            aria-controls="collapseInclusions">
                                            <h6 class="mb-0">
                                                {{ __('messages.what_is_included_not_included') }}
                                                <i class="fas fa-chevron-down ml-2 chevron-icon"></i>
                                            </h6>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseInclusions" class="collapse" aria-labelledby="headingInclusions"
                                    data-parent="#accordionInclusions">
                                    <div class="card-body">
                                        <div class="row text-center mb-3">
                                            <div class="col-sm-6">
                                                <h6 class="text-uppercase text-muted mb-2 text-left">
                                                    {{ __('messages.what_is_included') }}
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
                                    @if($accommodation->locationModel)
                                        {{ $accommodation->locationModel->tr('name') }}
                                    @else
                                        {{ $accommodation->tr('location') }}
                                    @endif
                                    ({{ $accommodation->nights_count }} {{ __('messages.nights') }})
                                    
                                    @if($accommodation->standardHotels->isNotEmpty())
                                        <br><small class="text-muted">{{ __('messages.standard') }}:
                                            {{ $accommodation->standardHotels->map(fn($h) => $h->tr('name'))->join(', ') }}
                                        </small>
                                    @elseif($accommodation->tr('standard_options'))
                                         <br><small class="text-muted">{{ __('messages.standard') }}:
                                            {{ $accommodation->tr('standard_options') }}</small>
                                    @endif

                                    @if($accommodation->comfortHotels->isNotEmpty())
                                        <br><small class="text-muted">{{ __('messages.comfort') }}:
                                             {{ $accommodation->comfortHotels->map(fn($h) => $h->tr('name'))->join(', ') }}
                                        </small>
                                    @elseif($accommodation->tr('comfort_options'))
                                        <br><small class="text-muted">{{ __('messages.comfort') }}:
                                            {{ $accommodation->tr('comfort_options') }}</small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    {{-- TAGS --}}
                    @if($tour->tags && $tour->tags->count() > 0)
                        <div class="mt-4">
                            <h5 class="mb-2"><i class="bx bx-purchase-tag-alt text-primary mr-1"></i>
                                {{ __('messages.tags') }}:</h5>
                            <div>
                                @foreach($tour->tags as $tag)
                                    <a href="{{ route('tours.tag.show', $tag->id) }}" class="badge badge-info p-2 mr-1 mb-1"
                                        style="font-size: 0.9rem;">
                                        {{ $tag->tr('name') }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
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

            @livewire('front.tour-reviews', ['tour' => $tour])

            {{-- BOOKING FORM (Livewire component) --}}
        </div>

        {{-- RIGHT: SIDEBAR --}}
        @livewire('front.tours-sidebar')
    </div>

    {{-- GALLERY MODAL --}}
    @if($tour->orderedMedia && $tour->orderedMedia->count() > 0)

        <style>
            /* Custom Fullscreen Modal for Bootstrap 4 */
            .modal-fullscreen {
                padding: 0 !important;
            }

            .modal-fullscreen .modal-dialog {
                width: 100%;
                max-width: none;
                height: 100%;
                margin: 0;
            }

            .modal-fullscreen .modal-content {
                height: 100%;
                border: 0;
                border-radius: 0;
            }

            .modal-fullscreen .modal-body {
                overflow: hidden;
                background-color: #000;
            }
        </style>

        <!-- Modal -->
        <div class="modal fade modal-fullscreen" id="galleryModal" tabindex="-1" role="dialog"
            aria-labelledby="galleryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-0 bg-dark p-3">
                        <h5 class="modal-title text-white" id="galleryModalLabel">
                            <i class="fas fa-images mr-2"></i> {{ $tour->tr('title') }}
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0 d-flex align-items-center justify-content-center">
                        <div id="galleryCarousel" class="carousel slide w-100 h-100" data-ride="carousel"
                            data-interval="false">
                            {{-- Indicators --}}
                            <ol class="carousel-indicators">
                                @foreach($tour->orderedMedia as $index => $media)
                                    <li data-target="#galleryCarousel" data-slide-to="{{ $index }}"
                                        class="{{ $index === 0 ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>

                            {{-- Slides --}}
                            <div class="carousel-inner h-100">
                                @foreach($tour->orderedMedia as $index => $media)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }} h-100">
                                        <div class="d-flex justify-content-center align-items-center h-100">
                                            <img src="{{ asset('uploads/' . $media->file_path) }}" class="d-block img-fluid"
                                                alt="{{ $media->file_name }}"
                                                style="max-height: 100vh; max-width: 100%; object-fit: contain;">
                                        </div>
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
                    <div class="modal-footer border-0 bg-dark justify-content-center py-2">
                        <span class="text-white small">
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
                document.addEventListener('livewire:initialized', () => {
                   @this.on('booking-success', (event) => {
                       const data = event[0]; // Livewire 3 event data is an array
                       
                       // Google Ads Conversion
                       // Ensure gtag is available, otherwise log error or skip
                       if (typeof gtag === 'function') {
                           gtag('event', 'conversion', {
                               'send_to': '{{ config('services.google_ads.conversion_id') }}/{{ config('services.google_ads.conversion_label') }}',
                               'value': data.value,
                               'currency': data.currency,
                               'transaction_id': data.transaction_id
                           });
                           console.log('Google Ads Conversion sent:', data);
                       } else {
                           console.warn('gtag is not defined. Conversion not sent.', data);
                       }
                   }); 
                });

                function showGalleryImage(index) {
                    $('#galleryCarousel').carousel(index);
                }

                $(document).ready(function () {
                    // Update image counter
                    $('#galleryCarousel').on('slid.bs.carousel', function (e) {
                        var currentIndex = $(e.relatedTarget).index() + 1;
                        $('#currentImageNumber').text(currentIndex);
                    });

                    // Keyboard navigation
                    $('#galleryModal').on('shown.bs.modal', function () {
                        $(document).on('keydown.gallery', function (e) {
                            if (e.keyCode == 37) { // Left arrow
                                $('#galleryCarousel').carousel('prev');
                            } else if (e.keyCode == 39) { // Right arrow
                                $('#galleryCarousel').carousel('next');
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

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Toggle chevron icon for group dates
                $('#moreGroupDates').on('show.bs.collapse', function () {
                    $('[data-target="#moreGroupDates"]').find('.when-collapsed').hide();
                    $('[data-target="#moreGroupDates"]').find('.when-expanded').show();
                });

                $('#moreGroupDates').on('hide.bs.collapse', function () {
                    $('[data-target="#moreGroupDates"]').find('.when-collapsed').show();
                    $('[data-target="#moreGroupDates"]').find('.when-expanded').hide();
                });

                // Toggle chevron icon for inclusions block
                $('#collapseInclusions').on('show.bs.collapse', function () {
                    $('[data-target="#collapseInclusions"]').find('.chevron-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                });

                $('#collapseInclusions').on('hide.bs.collapse', function () {
                    $('[data-target="#collapseInclusions"]').find('.chevron-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                });
            });
        </script>
    @endpush
</div>
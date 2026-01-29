<div>
    @if($heroSlide)
        <!-- ========== STATIC HERO (No Carousel) ========== -->
        <section id="home-static-hero" style="position: relative; height: 94vh; overflow: hidden; background: #000;">
            @php
                $extension = pathinfo($heroSlide->image, PATHINFO_EXTENSION);
                $filename = pathinfo($heroSlide->image, PATHINFO_FILENAME);
                $directory = dirname($heroSlide->image);
                $directory = $directory === '.' ? '' : $directory . '/';

                // WebP variants
                $mobileWebp = $directory . $filename . '_mobile.webp';
                $desktopWebp = $directory . $filename . '_desktop.webp';

                // URLs
                $mobileUrl = asset('uploads/' . $mobileWebp);
                $desktopUrl = asset('uploads/' . $desktopWebp);
                $originalUrl = asset('uploads/' . $heroSlide->image);
            @endphp

            <picture style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;">
                <!-- Mobile WebP -->
                <source media="(max-width: 768px)" srcset="{{ $mobileUrl }}" type="image/webp">
                <!-- Desktop WebP -->
                <source srcset="{{ $desktopUrl }}" type="image/webp">
                
                <!-- Fallback info -->
                <img src="{{ $originalUrl }}" 
                     alt="{{ $heroSlide->tr('title') }}"
                     style="width: 100%; height: 100%; object-fit: cover; opacity: 0.85;"
                     loading="eager" 
                     fetchpriority="high">
            </picture>

            <div class="container h-100 position-relative" style="z-index: 2;">
                <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center text-white pb-5">
                    <h1 class="display-3 font-weight-bold mb-3" style="text-shadow: 0 4px 10px rgba(0,0,0,0.5);">
                        {{ $heroSlide->tr('title') }}
                    </h1>
                    <p class="lead mb-4" style="text-shadow: 0 2px 5px rgba(0,0,0,0.5); font-weight: 500; max-width: 800px;">
                        {{ $heroSlide->tr('description') }}
                    </p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="{{ route('tours.category.index') }}" class="btn btn-primary rounded btn-lg px-4 mb-2 mb-sm-0 mr-sm-2">
                            {{ __('All Tours') }}
                        </a>
                        <a href="{{ route('front.tour-groups') }}" class="btn btn-outline-light rounded btn-lg px-4">
                            {{ __('By Dates') }}
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Overlay gradient for better text readability -->
            <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.25); z-index: 1;"></div>
        </section>
    @endif
    <!-- ABOUT -->
    <section class="py-5 bg-white" id="about">
        <div class="container py-4">
            <div class="row align-items-center gy-5">

                <!-- LEFT SIDE — TEXT -->
                <div class="col-lg-6">
                    <h1 class="fw-bold mb-4" style="font-size: 2rem; color: #212529;">
                        {{ __('messages.home_discover_title') }}
                    </h1>

                    <p class="text-muted mb-0"
                        style="font-size: 1.05rem; line-height: 1.7; text-indent: 1.5rem; text-align: justify;">
                        {{ __('messages.home_discover_text_1') }}
                    </p>

                    <p class="text-muted mb-0"
                        style="font-size: 1.05rem; line-height: 1.7; text-indent: 1.5rem; text-align: justify;">
                        {{ __('messages.home_discover_text_2') }}
                    </p>

                    <h3 class="fw-bold mb-3" style="color: #212529;">{{ __('messages.home_why_choose_title') }}</h3>

                    <ul class="about-features-list">
                        <li class="mb-0">{{ __('messages.home_why_choose_list_1') }}</li>
                        <li class="mb-0">{{ __('messages.home_why_choose_list_2') }}</li>
                        <li class="mb-0">{{ __('messages.home_why_choose_list_3') }}</li>
                        <li class="mb-0">{{ __('messages.home_why_choose_list_4') }}</li>
                        <li class="mb-0">{{ __('messages.home_why_choose_list_5') }}</li>
                        <li class="mb-0">{{ __('messages.home_why_choose_list_6') }}</li>
                    </ul>

                    <div class="mt-4">
                        <a href="{{ route('about') }}" class="btn btn-outline-danger btn-sm">
                            {{ __('messages.more_about_us') }}
                        </a>
                    </div>
                </div>
                <!-- /About -->

                <!-- RIGHT SIDE — IMAGE GRID -->
                <div class="col-lg-6">
                    <div class="about-grid">
                        <div class="home-gallery-thumb">
                            <img src="{{ asset('assets/images/tmfotos/i.webp') }}" alt="Turkmenistan" loading="lazy"
                                width="400" height="240">
                        </div>
                        <div class="home-gallery-thumb">
                            <img src="{{ asset('assets/images/tmfotos/81.webp') }}" alt="Turkmenistan" loading="lazy"
                                width="400" height="240">
                        </div>
                        <div class="home-gallery-thumb">
                            <img src="{{ asset('assets/images/tmfotos/i-1.webp') }}" alt="Turkmenistan" loading="lazy"
                                width="400" height="240">
                        </div>
                        <div class="home-gallery-thumb">
                            <img src="{{ asset('assets/images/tmfotos/gate.webp') }}" alt="Turkmenistan" loading="lazy"
                                width="400" height="240">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========== POPULAR TOURS – GETYOURGUIDE PREMIUM ========== -->
    <section id="tours" class="bg-light">
        <div class="container py-5">

            <!-- SECTION HEADER -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-3" style="font-size: 2rem;">
                        {{ __('messages.home_popular_title') ?? 'Popular tours in Turkmenistan' }}
                    </h2>
                    <p class="text-muted mb-0" style="font-size: 1.05rem; max-width: 680px;">
                        {{ __('messages.home_popular_subtitle') ?? 'Handpicked group & private tours carefully crafted by local experts.' }}
                    </p>
                </div>
                <div class="col-lg-4 d-flex align-items-center justify-content-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('tours.category.index') }}" class="btn btn-outline-secondary btn-sm">
                        {{ __('messages.view_all') ?? 'View all tours' }}
                    </a>
                </div>
            </div>

            <!-- TOURS GRID -->
            <div class="row">
                @foreach($tours as $tour)

                    @php
                        $badges = [
                            __('messages.badge_most_popular'),
                            __('messages.badge_best_price'),
                            __('messages.badge_new_tour'),
                            __('messages.badge_recommended'),
                            __('messages.badge_local_favorite')
                        ];
                        $badge = $badges[array_rand($badges)];
                    @endphp

                    <div class="col-md-6 col-lg-4 mb-4">

                        <div class="card border-0 shadow tour-card-gyg h-100"
                            style="border-radius: 16px; overflow: hidden; transition: .25s;">

                            <!-- TOP IMAGE -->
                            <div class="position-relative">
                                <a href="{{ route('tours.show', $tour->slug) }}">
                                    <img src="{{ $tour->first_media_url }}" class="w-100" alt="{{ $tour->tr('title') }}"
                                        loading="lazy" width="400" height="220">
                                </a>

                                <!-- BADGE -->
                                <span class="tour-badge-gyg">{{ $badge }}</span>

                                <!-- LOCATION CHIP -->
                                <span class="tour-location-chip">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $tour->tr('location_short') ?? $tour->tr('location') ?? 'Turkmenistan' }}
                                </span>

                                <!-- RATING CHIP (STATIC / PLACEHOLDER OR FROM DB) -->
                                <span class="rating-chip">
                                    <i class="fas fa-star"></i>
                                    {{ number_format($tour->average_rating, 1) }}
                                    <span
                                        class="ml-1 small">({{ trans_choice('messages.reviews_count', $tour->reviews_count) }})</span>
                                </span>
                            </div>

                            <!-- BODY -->
                            <div class="card-body d-flex flex-column" style="padding: 1.25rem;">

                                <!-- TITLE -->
                                <a href="{{ route('tours.show', $tour->slug) }}" class="text-decoration-none text-dark">
                                    <h5 class="fw-bold mb-3"
                                        style="font-size: 1.1rem; line-height: 1.4; min-height: 3rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $tour->tr('title') }}
                                    </h5>
                                </a>

                                <!-- ICONS -->
                                <div class="mb-3 text-secondary" style="font-size: 0.95rem;">
                                    <i class="fa-solid fa-car-side mr-2" title="Transport"></i>
                                    <i class="fa-solid fa-passport mr-2" title="Visa Support"></i>
                                    <i class="fa-solid fa-fire-flame-curved mr-2" title="Attractions"></i>
                                    <i class="fa-solid fa-hotel mr-2" title="Accommodation"></i>
                                    <i class="fa-solid fa-bus mr-2" title="Transfers"></i>
                                    <i class="fas fa-campground mr-2" title="Camping"></i>
                                </div>

                                <!-- INFO GRID -->
                                <div class="row g-2 mt-auto">

                                    <!-- LEFT COL: Duration & Type -->
                                    <div class="col-6 border-right pr-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="far fa-clock text-primary mr-2"
                                                style="width: 16px; text-align: center;"></i>
                                            <span class="small text-muted lh-1">
                                                {{ $tour->days ?? '2-3' }} {{ __('messages.days_label') ?? 'days' }}
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-users text-primary mr-2"
                                                style="width: 16px; text-align: center;"></i>
                                            <span class="small text-muted lh-1">
                                                {{ __('messages.small_group') ?? 'Small group' }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- RIGHT COL: Next & Price -->
                                    <div class="col-6 pl-3">
                                        @if($nextGroup = $tour->groupsOpen->first())
                                            <!-- Next Departure -->
                                            <div class="mb-2">
                                                <div class="text-xs text-muted text-uppercase fw-bold"
                                                    style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                                    {{ __('messages.next_departure') ?? 'Start' }}
                                                </div>
                                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                                    {{ \Carbon\Carbon::parse($nextGroup->starts_at)->format('d.m.Y') }}
                                                </div>
                                            </div>

                                            <!-- Prices -->
                                            <div class="d-flex flex-column">
                                                <!-- Single -->
                                                <div class="d-flex justify-content-between align-items-center small mb-1">
                                                    <span class="text-muted"><i class="fas fa-user-alt fa-xs mr-1"></i>
                                                        1:</span>
                                                    <span class="fw-bold">${{ $nextGroup->price_max }}</span>
                                                </div>
                                                <!-- Group -->
                                                <div
                                                    class="d-flex justify-content-between align-items-center small text-success">
                                                    <span class="fw-bold"><i class="fas fa-users fa-xs mr-1"></i> 4+:</span>
                                                    <span
                                                        class="fw-bold bg-success-subtle px-1 rounded">${{ $nextGroup->price_min }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div
                                                class="h-100 d-flex align-items-center justify-content-center text-muted small fst-italic">
                                                {{ __('messages.on_request') }}
                                            </div>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <!-- FOOTER -->
                            <div class="card-footer bg-white border-0 pb-4 px-3">
                                <a href="{{ route('tours.show', $tour->slug) }}" class="btn btn-danger w-100 py-2"
                                    style="border-radius: 12px; font-size: 1rem;">
                                    {{ __('messages.read_more_btn') }}
                                </a>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- ========== UPCOMING GROUP TOURS ========== -->
    @if(isset($groups) && $groups->count() > 0)
        <section class="bg-white">
            <div class="container py-5">
                <div class="row mb-4">
                    <div class="col-lg-8">
                        <h2 class="fw-bold mb-3" style="font-size: 2rem;">
                            {{ __('messages.available_dates') }}
                        </h2>
                        <p class="text-muted mb-0" style="font-size: 1.05rem; max-width: 680px;">
                            {{ __('messages.booking_info') }}
                        </p>
                    </div>
                    <div class="col-lg-4 d-flex align-items-center justify-content-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('front.tour-groups') }}" class="btn btn-outline-secondary btn-sm">
                            {{ __('messages.view_all_groups') ?? __('messages.view_all') }}
                        </a>
                    </div>
                </div>

                <div class="row">
                    @foreach($groups as $group)
                        @php
                            $available = max(0, (int) $group->freePlaces());
                            $capacity = (int) $group->max_people;
                            $booked = max(0, $capacity - $available);
                            $isFull = $available <= 0;
                        @endphp

                        <div class="col-12 mb-3">
                            <div class="tm-group-card {{ $isFull ? 'tm-group-card-full' : 'tm-group-card-available' }}">
                                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                                    <div class="mb-2 mb-md-0 pr-md-3">
                                        <div class="tm-group-title">

                                            {{ $group->tour?->tr('title') ?? $group->tour?->title }}

                                        </div>

                                        <div class="tm-group-meta-line mt-1">
                                            <span class="tm-pill tm-pill-date mr-1">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                {{ \Carbon\Carbon::parse($group->starts_at)->format('d.m.Y') }}
                                            </span>

                                            <span class="tm-pill tm-pill-booked mr-1">
                                                <i class="fas fa-user-check mr-1"></i>
                                                {{ __('messages.booked_badge') }}: {{ $booked }} / {{ $capacity }}
                                            </span>

                                            <span class="tm-pill tm-pill-available">
                                                <i class="fas fa-user-plus mr-1"></i>
                                                {{ __('messages.available_seats_badge') }}: {{ $available }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-md-right">
                                        @if($group->price_min)
                                            <div class="mb-1">
                                                <span class="tm-price-chip">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                    ${{ number_format($group->price_min, 0, '.', ' ') }}
                                                    <span class="tm-price-label">
                                                        {{ __('messages.price_per_person_badge') }}
                                                    </span>
                                                </span>
                                            </div>
                                        @endif

                                        <button type="button"
                                            class="btn tm-order-btn btn-sm mt-1 text-white {{ $isFull ? 'disabled' : '' }}"
                                            wire:click="openBookingModal({{ $group->id }})" @if($isFull) disabled @endif>
                                            <i class="fas fa-ticket-alt mr-1"></i>
                                            {{ $isFull ? __('messages.no_seats') : __('messages.order_button') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
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

                    <form wire:submit.prevent="submitBooking" novalidate
                        class="d-flex flex-column flex-grow-1 overflow-auto">
                        <div class="tm-modal-body">
                            @if($selectedGroup)
                                <div class="tm-tour-summary">
                                    <div class="tm-tour-summary-title">
                                        {{ $selectedGroup->tour?->tr('title') ?? $selectedGroup->tour?->title }}
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

                                <button type="submit" class="btn tm-order-btn text-white" wire:loading.attr="disabled">
                                    <span wire:loading.remove>{{ __('Send') }}</span>
                                    <span wire:loading>{{ __('Sending...') }}</span>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- ========== BORDER CROSSING & VISA SUPPORT – 3 STEPS ========== -->
    <section class="py-5 bg-light" id="borders">
        <div class="container py-4">

            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3" style="font-size: 2rem;">
                    {{ __('home_borders.title') ?? 'Visa, LOI & Border crossing support' }}
                </h2>
                <p class="text-muted mb-0" style="font-size: 1.05rem; max-width: 780px; margin: 0 auto;">
                    {{ __('home_borders.subtitle') ?? 'We help you get your Letter of Invitation (LOI), arrange visas and cross Turkmen borders smoothly.' }}
                </p>
            </div>

            <div class="row">
                {{-- Карточка 1: LOI --}}
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 safe-pill" style="border-radius: 16px;">
                        <div class="card-body text-center">
                            <div class="safe-icon mb-3">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <h5 class="fw-bold mb-2">
                                {{ __('home_borders.item1_title') ?? 'LOI (Letter of Invitation)' }}
                            </h5>
                            <p class="text-muted small mb-0">
                                {!! __('home_borders.item1_text')
    ?? 'We prepare your Letter of Invitation and advise which visa type fits your route and nationality.' !!}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Карточка 2: Виза --}}
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 safe-pill" style="border-radius: 16px;">
                        <div class="card-body text-center">
                            <div class="safe-icon mb-3">
                                <i class="fas fa-passport"></i>
                            </div>
                            <h5 class="fw-bold mb-2">
                                {{ __('home_borders.item2_title') ?? 'Visa support' }}
                            </h5>
                            <p class="text-muted small mb-0">
                                {!! __('home_borders.item2_text')
    ?? 'We guide you through visa-on-arrival or embassy procedures and provide all required documents.' !!}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Карточка 3: Граница --}}
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 safe-pill" style="border-radius: 16px;">
                        <div class="card-body text-center">
                            <div class="safe-icon mb-3">
                                <i class="fas fa-route"></i>
                            </div>
                            <h5 class="fw-bold mb-2">
                                {{ __('home_borders.item3_title') ?? 'Border crossing & transfers' }}
                            </h5>
                            <p class="text-muted small mb-0">
                                {!! __('home_borders.item3_text')
    ?? 'We arrange smooth crossings at Farap, Shavat, Kunya-Urgench, Howdan and other checkpoints with local drivers and guides.' !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('visa') }}" class="btn btn-danger px-4 py-2">
                    {{ __('home_borders.btn') ?? 'Learn more about visa & borders' }}
                </a>
            </div>

        </div>
    </section>


    <!-- ========== SAFE & GUARANTEED ENTRY ASSISTANCE ========== -->
    <section class="py-5 bg-light" id="safe-entry">
        <div class="container py-4">

            <h2 class="fw-bold text-center mb-4" style="font-size: 2rem;">
                {{ __('safe.title') }}
            </h2>

            <p class="text-center text-muted mb-5" style="font-size: 1.05rem; max-width: 750px; margin: 0 auto;">
                {{ __('safe.subtitle') }}
            </p>

            <div class="row g-4">

                <!-- Pill 1 -->
                <div class="col-md-4">
                    <div class="safe-pill text-center p-4">
                        <div class="safe-icon mb-3">
                            <i class="fas fa-passport"></i>
                        </div>
                        <h5 class="fw-bold mb-2">{{ __('safe.point1_title') }}</h5>
                        <p class="text-muted small">{{ __('safe.point1_text') }}</p>
                    </div>
                </div>

                <!-- Pill 2 -->
                <div class="col-md-4">
                    <div class="safe-pill text-center p-4">
                        <div class="safe-icon mb-3">
                            <i class="fas fa-route"></i>
                        </div>
                        <h5 class="fw-bold mb-2">{{ __('safe.point2_title') }}</h5>
                        <p class="text-muted small">{{ __('safe.point2_text') }}</p>
                    </div>
                </div>

                <!-- Pill 3 -->
                <div class="col-md-4">
                    <div class="safe-pill text-center p-4">
                        <div class="safe-icon mb-3">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5 class="fw-bold mb-2">{{ __('safe.point3_title') }}</h5>
                        <p class="text-muted small">{{ __('safe.point3_text') }}</p>
                    </div>
                </div>

            </div>

            <div class="text-center mt-5">
                <a href="{{ route('tours.category.index')}}" class="btn btn-danger px-4 py-2"
                    style="border-radius: 10px;">
                    {{ __('safe.btn') }}
                </a>
            </div>

        </div>
    </section>

    <!-- ========== REVIEWS ========== -->
    @if(isset($reviews) && $reviews->count() > 2)
        <section class="py-5 bg-white" id="reviews">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-3" style="font-size: 2rem;">
                        {{ __('messages.reviews_title') ?? 'Client Reviews' }}
                    </h2>
                    <p class="text-muted mb-0" style="font-size: 1.05rem; max-width: 780px; margin: 0 auto;">
                        {{ __('messages.reviews_subtitle') ?? 'What our travelers say about us' }}
                    </p>
                </div>

                <div class="row">
                    @foreach($reviews as $review)
                        <div class="col-md-4 mb-4">
                            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 16px;">
                                <div class="card-body">
                                    <div class="mb-3 text-warning">
                                        @for($i = 0; $i < $review->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @for($i = $review->rating; $i < 5; $i++)
                                            <i class="far fa-star text-muted" style="opacity: 0.3;"></i>
                                        @endfor
                                    </div>

                                    <p class="text-muted" style="font-size: 0.95rem; line-height: 1.6; min-height: 80px;">
                                        "{{ Str::limit($review->comment, 150) }}"
                                    </p>

                                    <div class="d-flex align-items-center mt-4">
                                        <img src="{{ $review->user->avatar_url }}" class="rounded-circle mr-3 border"
                                            style="width: 50px; height: 50px; object-fit: cover;"
                                            alt="{{ $review->user->name }}" width="50" height="50">
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark">{{ $review->user->name }}</h6>
                                            <small class="text-muted">{{ $review->created_at->format('d.m.Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- ========== CONTACTS ========== -->
    @livewire('front.contact-form-component')

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                @this.on('booking-success', (event) => {
                    const data = event[0];

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
        </script>
    @endpush
</div>
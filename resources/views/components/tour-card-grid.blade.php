@props(['tour'])

@php
    $badges = ['Most Popular','Best Price','New Tour','Recommended','Local Favorite'];
    $badge = $badges[array_rand($badges)];
@endphp

<div class="card border-0 shadow tour-card-gyg h-100"
     style="border-radius: 16px; overflow: hidden; transition: .25s;">

    <!-- TOP IMAGE -->
    <div class="position-relative">
        <a href="{{ route('tours.show', $tour->slug) }}">
            <img src="{{ $tour->first_media_url }}"
                 class="w-100"
                 style="height: 260px; object-fit: cover;">
        </a>

        <!-- BADGE -->
        <span class="tour-badge-gyg">{{ $badge }}</span>
    </div>

    <!-- BODY -->
    <div class="card-body" style="padding: 1.25rem 1.25rem 0.5rem;">

        <!-- TITLE -->
        <a href="{{ route('tours.show', $tour->slug) }}"
           class="text-decoration-none text-dark">
            <h5 class="fw-bold mb-2" style="font-size: 1.15rem; line-height: 1.3;">
                {{ $tour->tr('title') }}
            </h5>
        </a>

        <!-- ICONS (jeep, border, crater, hotel, train) -->
        <div class="mb-3" style="font-size: 1rem; color:#444;">
            <i class="fa-solid fa-car-side mr-2"></i>
            <i class="fa-solid fa-passport mr-2"></i>
            <i class="fa-solid fa-fire-flame-curved mr-2"></i>
            <i class="fa-solid fa-hotel mr-2"></i>
            <i class="fa-solid fa-bus mr-2"></i>
            <i class="fas fa-campground mr-2"></i>
        </div>

        <!-- SHORT DESCRIPTION -->
        <!-- <p class="text-muted small mb-3" style="line-height: 1.45;">
            {!! Str::words(strip_tags($tour->tr('short_description')), 15, '...') !!}
        </p> -->

        <!-- RATING + DURATION -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <!-- Duration -->
            <span class="badge-duration-gyg">
                {{ trans_choice('messages.days', $tour->duration_days, ['count' => $tour->duration_days]) }}
            </span>

            <!-- Rating -->
            <div class="text-success" style="font-size: 1rem;">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
            </div>
        </div>

        {{-- 2 Prices Display --}}
        @if($nextGroup = $tour->groupsOpen->first())
            <!-- Next Departure -->
            <div class="mb-2 d-flex align-items-center justify-content-between" style="font-size: 0.9rem;">
                <span class="text-muted">
                    <i class="fas fa-calendar-alt text-primary mr-1"></i>
                    {{ __('messages.next_departure') ?? 'Ближайший выезд' }}
                </span>
                <strong>{{ \Carbon\Carbon::parse($nextGroup->starts_at)->format('d.m.Y') }}</strong>
            </div>

            <div class="tour-price-box d-flex flex-column mb-3">

                <!-- Цена за 1 человека -->
                <div class="price-chip-single mb-1">
                    <i class="fas fa-user mr-1"></i>
                    1 {{ __('messages.person') ?? 'чел.' }}:
                    <strong>${{ $nextGroup->price_max }}</strong>
                </div>

                <!-- Цена за группу -->
                <div class="price-chip-group">
                    <i class="fas fa-users mr-1"></i>
                    {{ $nextGroup->max_people }} {{ __('messages.people') ?? 'чел.' }}:
                    <strong>${{ $nextGroup->price_min }}</strong>
                </div>

            </div>
        @endif


    </div>

    <!-- FOOTER -->
    <div class="card-footer bg-white border-0 pb-4 px-3">
        <a href="{{ route('tours.show', $tour->slug) }}"
           class="btn btn-danger w-100 py-2"
           style="border-radius: 12px; font-size: 1rem;">
            {{ __('messages.read_more') }}
        </a>
    </div>

</div>

@props(['tour'])

@php
    $badges = ['Most Popular', 'Best Price', 'New Tour', 'Recommended', 'Local Favorite'];
    $badge = $badges[array_rand($badges)];
@endphp

<div class="card border-0 shadow tour-card-gyg h-100" style="border-radius: 16px; overflow: hidden; transition: .25s;">

    <!-- TOP IMAGE -->
    <div class="position-relative">
        <a href="{{ route('tours.show', $tour->slug) }}">
            <img src="{{ $tour->first_media_url }}" class="w-100" style="height: 260px; object-fit: cover;"
                alt="{{ $tour->tr('title') }}" loading="lazy">
        </a>

        <!-- BADGE -->
        <span class="tour-badge-gyg">{{ $badge }}</span>

        <!-- LOCATION CHIP -->
        <span class="tour-location-chip">
            <i class="fas fa-map-marker-alt"></i>
            {{ $tour->tr('location_short') ?? $tour->tr('location') ?? 'Turkmenistan' }}
        </span>

        <!-- RATING CHIP -->
        <span class="rating-chip">
            <i class="fas fa-star"></i>
            4.9 <span class="ml-1 small">({{ rand(18, 57) }} reviews)</span>
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
            #{{ $tour->id }}    
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
                    <i class="far fa-clock text-primary mr-2" style="width: 16px; text-align: center;"></i>
                    <span class="small text-muted lh-1">
                        {{ $tour->days ?? '2-3' }} {{ __('messages.days_label') ?? 'days' }}
                    </span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-users text-primary mr-2" style="width: 16px; text-align: center;"></i>
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
                            <span class="text-muted"><i class="fas fa-user-alt fa-xs mr-1"></i> 1:</span>
                            <span class="fw-bold">${{ $nextGroup->price_max }}</span>
                        </div>
                        <!-- Group -->
                        <div class="d-flex justify-content-between align-items-center small text-success">
                            <span class="fw-bold"><i class="fas fa-users fa-xs mr-1"></i> 4+:</span>
                            <span class="fw-bold bg-success-subtle px-1 rounded">${{ $nextGroup->price_min }}</span>
                        </div>
                    </div>
                @else
                    <div class="h-100 d-flex align-items-center justify-content-center text-muted small fst-italic">
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
            {{ __('messages.read_more') }}
        </a>
    </div>

</div>
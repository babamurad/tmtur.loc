<div>
    <div class="container mt-4 pt-2">

        <div class="row justify-content-center mb-3">
            <div class="col-lg-8 text-center">
                <h1 class="tm-section-title mb-2">
                    {{ __('messages.available_dates') }}
                </h1>
                <p class="tm-section-subtitle">
                    {{ __('messages.group_dates_subtitle') }}
                </p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="tm-filters-card mb-3">
            <div class="row">
                <div class="col-md-4 mb-2 mb-md-0">
                    <label for="monthFilter">{{ __('Месяц') }}</label>
                    <select wire:model.live="month" id="monthFilter" class="form-control form-control-sm">
                        @foreach($months as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <label for="yearFilter">{{ __('Год') }}</label>
                    <select wire:model.live="year" id="yearFilter" class="form-control form-control-sm">
                        @foreach($years as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end justify-content-md-end">
                    <div class="small text-muted mt-2 mt-md-0">
                        {{ __('messages.small_groups_note') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Groups list --}}
        <div class="row">
            @forelse($groups as $group)
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
                                    <a href="{{ route('tours.show', $group->tour?->slug) }}">
                                        {{ $group->tour?->tr('title') ?? $group->tour?->title }}
                                    </a>
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
                                @if($group->price_max || $group->price_min)
                                    <div class="d-flex flex-column align-items-md-end mb-2">
                                        @if($group->price_max)
                                            <div class="d-flex align-items-center mb-1" title="{{ __('1 person') }}">
                                                <span class="text-muted small mr-2" style="font-size: 0.85rem;"><i
                                                        class="fas fa-user-alt fa-xs"></i> 1:</span>
                                                <span
                                                    class="font-weight-bold text-dark">${{ number_format($group->price_max, 0, '.', ' ') }}</span>
                                            </div>
                                        @endif

                                        @if($group->price_min)
                                            <div class="d-flex align-items-center text-success" title="{{ __('4+ people') }}">
                                                <span class="font-weight-bold small mr-2" style="font-size: 0.85rem;"><i
                                                        class="fas fa-users fa-xs"></i> 4+:</span>
                                                <span class="font-weight-bold bg-success-subtle px-2 rounded"
                                                    style="background-color: #d1e7dd; color: #0f5132;">${{ number_format($group->price_min, 0, '.', ' ') }}</span>
                                            </div>
                                        @endif
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
            @empty
                <div class="col-12 text-center tm-empty-state">
                    {{ __('messages.no_tour_groups_available') }}
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="tm-pagination-wrapper d-flex justify-content-center">
            {{ $groups->links() }}
        </div>
    </div>

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
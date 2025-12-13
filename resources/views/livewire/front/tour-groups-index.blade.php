<div>
    <div class="container mt-4 pt-2">

        {{-- Styles for tour groups index + modal --}}
        <style>
            .tm-section-title {
                font-weight: 700;
                font-size: 1.8rem;
            }

            .tm-section-subtitle {
                font-size: 0.95rem;
                color: #6b7280;
                max-width: 640px;
                margin: 0 auto 0.25rem auto;
            }

            .tm-filters-card {
                border-radius: 16px;
                background: #f9fafb;
                border: 1px solid #e5e7eb;
                padding: 14px 18px;
            }

            .tm-filters-card label {
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: #6b7280;
                margin-bottom: 4px;
                font-weight: 600;
            }

            .tm-filters-card .form-control {
                font-size: 0.9rem;
                border-radius: 999px;
            }

            .tm-filters-card .form-control:focus {
                border-color: #ff4b57;
                box-shadow: 0 0 0 0.1rem rgba(255, 75, 87, 0.25);
            }

            .tm-group-card {
                border-radius: 18px;
                border: 1px solid #e5e7eb;
                padding: 14px 18px 12px;
                background: #ffffff;
                box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
                transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
            }

            .tm-group-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
                border-color: #ffb4b8;
            }

            .tm-group-card-full {
                border-left: 4px solid #ef4444;
            }

            .tm-group-card-available {
                border-left: 4px solid #10b981;
            }

            .tm-group-title {
                font-size: 1rem;
                font-weight: 600;
                margin-bottom: 4px;
            }

            .tm-group-title a {
                color: #111827;
            }

            .tm-group-title a:hover {
                text-decoration: none;
                color: #ff4b57;
            }

            .tm-group-meta-line {
                font-size: 0.85rem;
                color: #6b7280;
            }

            .tm-pill {
                display: inline-flex;
                align-items: center;
                border-radius: 999px;
                padding: 3px 10px;
                font-size: 0.75rem;
                font-weight: 500;
            }

            .tm-pill-date {
                background: #eff6ff;
                color: #1d4ed8;
            }

            .tm-pill-booked {
                background: #e0f2fe;
                color: #075985;
            }

            .tm-pill-available {
                background: #ecfdf3;
                color: #047857;
            }

            .tm-price-chip {
                display: inline-flex;
                align-items: center;
                border-radius: 999px;
                padding: 4px 11px;
                background: #fff7ed;
                border: 1px solid #fed7aa;
                font-size: 0.82rem;
                font-weight: 600;
                white-space: nowrap;
            }

            .tm-price-chip i {
                margin-right: 4px;
            }

            .tm-price-label {
                font-size: 0.7rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #9ca3af;
                margin-left: 6px;
            }

            .tm-order-btn {
                border-radius: 999px;
                padding: 6px 16px;
                font-size: 0.86rem;
                font-weight: 600;
                background: linear-gradient(135deg, #ff4b57, #ff7a4d);
                border: none;
            }

            .tm-order-btn.disabled,
            .tm-order-btn:disabled {
                background: #e5e7eb;
                color: #9ca3af;
                border: none;
            }

            .tm-empty-state {
                padding: 40px 0;
                color: #9ca3af;
                font-size: 0.95rem;
            }

            .tm-pagination-wrapper {
                margin-top: 10px;
            }

            /* Modal styles (в том же стиле, что Visa-модал) */
            .tm-modal .modal-dialog {
                max-width: 620px;
            }

            .tm-modal .modal-content {
                border-radius: 20px;
                border: none;
                overflow: hidden;
                background: rgba(255, 255, 255, 0.96);
                box-shadow: 0 18px 45px rgba(0, 0, 0, 0.18);
                backdrop-filter: blur(14px);
            }

            .tm-modal-header {
                background: linear-gradient(135deg, #ff4b57, #ff7a4d);
                color: #fff;
                padding: 18px 24px 14px;
                border-bottom: none;
                position: relative;
            }

            .tm-modal-header .tm-icon-circle {
                width: 40px;
                height: 40px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.18);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-right: 10px;
                font-size: 18px;
            }

            .tm-modal-header h5 {
                font-weight: 700;
                font-size: 1.1rem;
                margin-bottom: 2px;
            }

            .tm-modal-header p {
                font-size: 0.8rem;
                margin-bottom: 0;
                opacity: 0.9;
            }

            .tm-modal-close {
                position: absolute;
                right: 14px;
                top: 12px;
                color: #fff;
                opacity: 0.9;
                font-size: 1.3rem;
            }

            .tm-modal-body {
                padding: 18px 22px 20px;
            }

            .tm-tour-summary {
                border-radius: 16px;
                background: #f9fafb;
                border: 1px solid #e5e7eb;
                padding: 10px 14px;
                font-size: 0.82rem;
                margin-bottom: 14px;
            }

            .tm-tour-summary-title {
                font-weight: 600;
                font-size: 0.9rem;
                margin-bottom: 3px;
            }

            .tm-tour-summary-meta span {
                display: inline-flex;
                align-items: center;
                margin-right: 10px;
            }

            .tm-tour-summary-meta i {
                margin-right: 4px;
            }

            .tm-form-label {
                font-size: 0.78rem;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                font-weight: 600;
                color: #6b7280;
                margin-bottom: 4px;
            }

            .tm-form-control {
                border-radius: 999px;
                border: 1px solid #d1d5db;
                padding-left: 16px;
                padding-right: 16px;
                height: 46px;
                font-size: 0.9rem;
            }

            .tm-form-control:focus {
                border-color: #ff4b57;
                box-shadow: 0 0 0 0.1rem rgba(255, 75, 87, 0.25);
            }

            .tm-form-control.is-invalid {
                border-color: #e11d48;
            }

            .tm-textarea {
                border-radius: 16px;
                min-height: 90px;
                resize: vertical;
            }

            .tm-error {
                font-size: 0.78rem;
                color: #e11d48;
                margin-top: 3px;
            }
        </style>

        <div class="row justify-content-center mb-3">
            <div class="col-lg-8 text-center">
                <h2 class="tm-section-title mb-2">
                    {{ __('messages.available_dates') }}
                </h2>
                <p class="tm-section-subtitle">
                    Выберите месяц, чтобы увидеть доступные даты групповых туров. / Choose your month to see available
                    group departures.
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
                        Малые группы и гарантированные выезды после подтверждения. / Small groups and guaranteed
                        departures after confirmation.
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

                                <button type="button" class="btn tm-order-btn btn-sm mt-1 {{ $isFull ? 'disabled' : '' }}"
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
            <div class="modal-dialog modal-dialog-centered" role="document">
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

                    <form wire:submit.prevent="submitBooking" novalidate>
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

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input @error('gdpr_consent') is-invalid @enderror"
                                    id="gdpr_consent" wire:model="gdpr_consent">
                                <label class="form-check-label" for="gdpr_consent">
                                    {{ __('messages.gdpr_consent_statement') }}
                                </label>
                                @error('gdpr_consent')
                                    <div class="tm-error d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            @error('booking_general')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <button type="button" class="btn btn-secondary" wire:click="closeBookingModal">
                                    {{ __('Отмена') }}
                                </button>

                                <button type="submit" class="btn tm-order-btn" wire:loading.attr="disabled">
                                    <span wire:loading.remove>{{ __('Отправить') }}</span>
                                    <span wire:loading>{{ __('Отправка...') }}</span>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
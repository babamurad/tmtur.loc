@props(['days' => __('visa.days_duration')])

<section class="py-5" id="visa">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="fw-bold">{{ __('visa.title') }}</h1>
                    <p class="lead text-muted">{{ __('visa.subtitle') }}</p>
                </div>

                <!-- Intro -->
                <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <span>{{ __('visa.intro') }}</span>
                </div>

                @if (session()->has('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Required docs -->
                <h4 class="fw-semibold mb-3">{{ __('visa.docs_title') }}</h4>
                <div class="list-group list-group-flush mb-4">
                    <!-- passport -->
                    <div class="list-group-item px-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-passport text-primary me-3 mt-1"></i>
                            <div class="p-2">
                                <h6 class="mb-1">{{ __('visa.passport.title') }}</h6>
                                <small class="text-muted">{{ __('visa.passport.hint') }}</small>
                            </div>
                        </div>
                    </div>
                    <!-- photo -->
                    <div class="list-group-item px-0 py-3 mb-2 border rounded-3 shadow-sm">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-badge text-primary me-3 ms-2 fs-4"></i>
                            <div class="p-2">
                                <h6 class="mb-1 fw-bold">{{ __('visa.photo.title') }}</h6>
                                <small class="text-secondary">{{ __('visa.photo.hint') }}</small>
                            </div>
                        </div>
                    </div>
                    <!-- questionnaire -->
                    <div class="list-group-item px-0 py-3 mb-2 border rounded-3 shadow-sm">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-ui-checks text-primary me-3 ms-2 fs-4"></i>
                            <div class="p-2">
                                <h6 class="mb-1 fw-bold">{{ __('visa.questionnaire.title') }}</h6>
                                <ul class="small text-secondary mb-0 ps-0 list-unstyled pl-3">
                                    @foreach(__('visa.questionnaire.fields') as $f)
                                        <li class="mb-1">
                                            <i class="fa-solid fa-check fa-fw me-2 text-success mr-1"></i>{{ $f }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="d-flex align-items-center p-4 bg-light rounded-3 mb-4 shadow-sm">
                    <i class="bi bi-envelope-at-fill text-danger me-4 fs-2"></i>
                    <div>
                        <h5 class="mb-1 fw-bold">{{ __('visa.email') }}</h5>
                        <a href="#" wire:click.prevent="openBookingModal"
                            class="text-decoration-none fs-6 text-primary">tmtourism24@gmail.com</a>
                    </div>
                </div>

                <!-- Timeline -->
                <h4 class="fw-semibold mb-3 pt-3 border-top">{{ __('visa.timeline') }}</h4>
                <p class="mb-4">
                    {!! __('visa.timeline_txt', ['days' => '<span class="badge bg-success fs-6 py-2 px-3">' . $days . '</span>']) !!}
                </p>

                <!-- Where to get visa -->
                <h4 class="fw-semibold mb-3 pt-3 border-top">{{ __('visa.where_title') }}</h4>
                <p class="text-muted mb-3">{{ __('visa.where_txt') }}</p>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-start mb-2"><i
                            class="bi bi-check-circle-fill text-success me-2 mt-1"></i> {!! __('visa.where_opt1') !!}
                    </li>
                    <li class="d-flex align-items-start"><i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                        {!! __('visa.where_opt2') !!}</li>
                </ul>

            </div>
        </div>
    </div>

    {{-- Styles for visa modal --}}
    <style>
        .tm-modal .modal-dialog {
            max-width: 540px;
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
            font-size: 1.15rem;
            margin-bottom: 2px;
        }

        .tm-modal-header p {
            font-size: 0.85rem;
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

        .tm-submit-btn {
            border-radius: 999px;
            height: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0 22px;
            border: none;
            background: linear-gradient(135deg, #ff4b57, #ff7a4d);
        }

        .tm-submit-btn:focus,
        .tm-submit-btn:hover {
            opacity: 0.95;
        }

        .tm-footnote {
            font-size: 0.75rem;
            color: #6b7280;
            line-height: 1.3;
        }

        .tm-footnote strong {
            font-weight: 600;
        }
    </style>

    {{-- Модальное окно --}}
    @if($showBookingModal)
        <div class="modal fade show d-block tm-modal" tabindex="-1" role="dialog" aria-modal="true"
            style="background: rgba(0,0,0,0.55);">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    {{-- HEADER --}}
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
                                    {{ __('messages.contact_us') }}
                                </h5>
                                <p class="mb-0">
                                    {{ __('visa.subtitle') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- BODY + FORM --}}
                    <form wire:submit.prevent="submitBooking" novalidate>
                        <div class="tm-modal-body">
                            <div class="mb-3">
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

                            <div class="mb-3">
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

                            <div class="mb-3">
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

                            <div class="mb-3">
                                <label for="booking_message" class="tm-form-label">
                                    {{ __('messages.modal_message_label') }}
                                </label>
                                <textarea id="booking_message" rows="3"
                                    class="form-control tm-form-control tm-textarea @error('booking_message') is-invalid @enderror"
                                    wire:model="booking_message"
                                    placeholder="{{ __('Tell us about your plans, dates and questions') }}"></textarea>
                                @error('booking_message')
                                    <div class="tm-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input @error('gdpr_consent') is-invalid @enderror"
                                    id="gdpr_consent" wire:model="gdpr_consent">
                                <label class="form-check-label" for="gdpr_consent">
                                    {{ __('messages.gdpr_consent_statement') }}
                                </label>
                                @error('gdpr_consent')
                                    <div class="tm-error d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <button type="button" class="btn btn-dark rounded" wire:click="closeBookingModal">
                                    {{ __('Отмена') }}
                                </button>

                                <div class="d-flex align-items-center">
                                    <button type="submit" class="btn tm-submit-btn text-white" wire:loading.attr="disabled">
                                        <span wire:loading.remove>
                                            {{ __('Отправить') }}
                                        </span>
                                        <span wire:loading>
                                            {{ __('Отправка...') }}
                                        </span>
                                    </button>

                                    <div class="tm-footnote text-right ml-3">
                                        <div><strong>{{ __('No prepayment required.') }}</strong></div>
                                        <div>{{ __('We usually reply within a few hours.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endif

</section>
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

    {{-- Модальное окно --}}
    @if($showBookingModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-modal="true"
            style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('messages.contact_us') }}
                        </h5>
                        <button type="button" class="close btn-close" aria-label="Close" wire:click="closeBookingModal">
                        </button>
                    </div>

                    <form wire:submit.prevent="submitBooking">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="booking_name"
                                        class="form-label">{{ __('messages.modal_name_label') }}</label>
                                    <input type="text" id="booking_name"
                                        class="form-control @error('booking_name') is-invalid @enderror"
                                        wire:model="booking_name">
                                    @error('booking_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="booking_email"
                                        class="form-label">{{ __('messages.modal_email_label') }}</label>
                                    <input type="email" id="booking_email"
                                        class="form-control @error('booking_email') is-invalid @enderror"
                                        wire:model="booking_email">
                                    @error('booking_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="booking_phone"
                                        class="form-label">{{ __('messages.modal_phone_label') }}</label>
                                    <input type="text" id="booking_phone"
                                        class="form-control @error('booking_phone') is-invalid @enderror"
                                        wire:model="booking_phone">
                                    @error('booking_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="booking_message"
                                    class="form-label">{{ __('messages.modal_message_label') }}</label>
                                <textarea id="booking_message" rows="3"
                                    class="form-control @error('booking_message') is-invalid @enderror"
                                    wire:model="booking_message"></textarea>
                                @error('booking_message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input @error('gdpr_consent') is-invalid @enderror"
                                    id="gdpr_consent" wire:model="gdpr_consent">
                                <label class="form-check-label" for="gdpr_consent">
                                    {{ __('messages.gdpr_consent_statement') }}
                                </label>
                                @error('gdpr_consent') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeBookingModal">
                                {{ __('Отмена') }}
                            </button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                {{ __('Отправить') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</section>
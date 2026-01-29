<div>
    {{-- H1 & Intro --}}
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="fw-bold mb-4" style="font-size: 2.5rem; color: #212529;">
                        {{ __('messages.about_title') }}
                    </h1>
                    <p class="text-muted mb-0 mx-auto" style="font-size: 1.15rem; line-height: 1.8; max-width: 800px;">
                        {{ __('messages.about_intro') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Block 1: Approach --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="pr-md-4">
                        <h2 class="fw-bold mb-3">{{ __('messages.about_approach_title') }}</h2>
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex">
                                <i class="fas fa-check-circle text-success mt-1 mr-3"></i>
                                <span>{{ __('messages.about_approach_1') }}</span>
                            </li>
                            <li class="mb-3 d-flex">
                                <i class="fas fa-check-circle text-success mt-1 mr-3"></i>
                                <span>{{ __('messages.about_approach_2') }}</span>
                            </li>
                            <li class="mb-0 d-flex">
                                <i class="fas fa-check-circle text-success mt-1 mr-3"></i>
                                <span>{{ __('messages.about_approach_3') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    {{-- Placeholder for image if needed, or just a visual element --}}
                    <div class="bg-white p-5 rounded shadow-sm text-center">
                        <i class="fas fa-route fa-4x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Block 2: Visa, LOI --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center flex-md-row-reverse">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="pl-md-4">
                        <h2 class="fw-bold mb-3">{{ __('messages.about_borders_title') }}</h2>
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex">
                                <i class="fas fa-passport text-danger mt-1 mr-3"></i>
                                <span>{{ __('messages.about_borders_1') }}</span>
                            </li>
                            <li class="mb-3 d-flex">
                                <i class="fas fa-info-circle text-danger mt-1 mr-3"></i>
                                <span>{{ __('messages.about_borders_2') }}</span>
                            </li>
                            <li class="mb-0 d-flex">
                                <i class="fas fa-map-marked-alt text-danger mt-1 mr-3"></i>
                                <span>{{ __('messages.about_borders_3') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-light p-5 rounded shadow-sm text-center">
                        <i class="fas fa-passport fa-4x text-danger opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Block 3: Transparency --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="pr-md-4">
                        <h2 class="fw-bold mb-3">{{ __('messages.about_transparency_title') }}</h2>
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex">
                                <i class="fas fa-search-dollar text-primary mt-1 mr-3"></i>
                                <span>{{ __('messages.about_transparency_1') }}</span>
                            </li>
                            <li class="mb-3 d-flex">
                                <i class="fas fa-hand-holding-usd text-primary mt-1 mr-3"></i>
                                <span>{{ __('messages.about_transparency_2') }}</span>
                            </li>
                            <li class="mb-0 d-flex">
                                <i class="fas fa-star text-primary mt-1 mr-3"></i>
                                <span>{{ __('messages.about_transparency_3') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white p-5 rounded shadow-sm text-center">
                        <i class="fas fa-handshake fa-4x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Block 4: Comfort and Safety --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center flex-md-row-reverse">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="pl-md-4">
                        <h2 class="fw-bold mb-3">{{ __('messages.about_comfort_title') }}</h2>
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex">
                                <i class="fas fa-car text-warning mt-1 mr-3"></i>
                                <span>{{ __('messages.about_comfort_1') }}</span>
                            </li>
                            <li class="mb-3 d-flex">
                                <i class="fas fa-tools text-warning mt-1 mr-3"></i>
                                <span>{{ __('messages.about_comfort_2') }}</span>
                            </li>
                            <li class="mb-0 d-flex">
                                <i class="fas fa-smile text-warning mt-1 mr-3"></i>
                                <span>{{ __('messages.about_comfort_3') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-light p-5 rounded shadow-sm text-center">
                        <i class="fas fa-shield-alt fa-4x text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Block 5: How we work (3 steps) --}}
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">{{ __('messages.about_work_title') }}</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="p-4 bg-white rounded shadow-sm h-100">
                        <div class="mb-3">
                            <span
                                class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
                                style="width: 50px; height: 50px; font-size: 1.5rem;">1</span>
                        </div>
                        <h5 class="fw-bold">{{ __('messages.about_work_step_1_title') }}</h5>
                        <p class="text-muted mb-0">{{ __('messages.about_work_step_1_text') }}</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="p-4 bg-white rounded shadow-sm h-100">
                        <div class="mb-3">
                            <span
                                class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
                                style="width: 50px; height: 50px; font-size: 1.5rem;">2</span>
                        </div>
                        <h5 class="fw-bold">{{ __('messages.about_work_step_2_title') }}</h5>
                        <p class="text-muted mb-0">{{ __('messages.about_work_step_2_text') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm h-100">
                        <div class="mb-3">
                            <span
                                class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
                                style="width: 50px; height: 50px; font-size: 1.5rem;">3</span>
                        </div>
                        <h5 class="fw-bold">{{ __('messages.about_work_step_3_title') }}</h5>
                        <p class="text-muted mb-0">{{ __('messages.about_work_step_3_text') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-5 bg-white text-center">
        <div class="container">
            <h2 class="fw-bold mb-4">{{ __('messages.about_cta_title') }}</h2>
            <button type="button" wire:click="openModal" class="btn btn-danger btn-lg px-5 py-3 rounded-pill fw-bold">
                {{ __('messages.about_cta_btn') }}
            </button>
            <p class="mt-3 text-muted">
                {{ __('messages.about_email_label') }} <a href="mailto:tmtourism24@gmail.com"
                    class="text-decoration-none text-dark fw-bold">tmtourism24@gmail.com</a>
            </p>
        </div>
    </section>

    {{-- Contact Modal --}}
    @if($showModal)
        <div class="modal fade show d-block tm-modal" tabindex="-1" role="dialog" aria-modal="true"
            style="background: rgba(0,0,0,0.55);">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="tm-modal-header">
                        <button type="button" class="close tm-modal-close" aria-label="Close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <div class="d-flex align-items-center">
                            <div class="tm-icon-circle">
                                ✉
                            </div>
                            <div>
                                <h5 class="mb-0">
                                    {{ __('messages.modal_program_request_title') }}
                                </h5>
                                <p class="mb-0">
                                    {{ __('messages.modal_program_request_subtitle') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($success)
                        <div class="tm-modal-body">
                            <div class="text-center py-5">
                                <div class="mb-3 text-success">
                                    <i class="fas fa-check-circle fa-4x"></i>
                                </div>
                                <h5 class="mb-3">{{ __('messages.booking_request_sent_successfully') }}</h5>
                                <p class="text-muted">
                                    {{ __('messages.we_will_contact_you_soon') ?? 'Мы свяжемся с вами в ближайшее время.' }}</p>
                                <button type="button" class="btn btn-secondary mt-3" wire:click="closeModal">
                                    {{ __('messages.close') }}
                                </button>
                            </div>
                        </div>
                    @else
                        <form wire:submit.prevent="submit" novalidate class="d-flex flex-column flex-grow-1 overflow-auto">
                            {{-- Honeypot --}}
                            <div style="position:absolute; left:-9999px; top:auto; width:1px; height:1px; overflow:hidden;">
                                <label>Leave this field empty</label>
                                <input type="text" wire:model.defer="hp" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="tm-modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name" class="tm-form-label">
                                            {{ __('messages.modal_name_label') }}
                                        </label>
                                        <input type="text" id="name"
                                            class="form-control tm-form-control @error('name') is-invalid @enderror"
                                            wire:model="name">
                                        @error('name')
                                            <div class="tm-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="email" class="tm-form-label">
                                            {{ __('messages.modal_email_label') }}
                                        </label>
                                        <input type="email" id="email"
                                            class="form-control tm-form-control @error('email') is-invalid @enderror"
                                            wire:model="email">
                                        @error('email')
                                            <div class="tm-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label for="phone" class="tm-form-label">
                                            {{ __('messages.modal_phone_label') }}
                                        </label>
                                        <input type="text" id="phone"
                                            class="form-control tm-form-control @error('phone') is-invalid @enderror"
                                            wire:model="phone">
                                        @error('phone')
                                            <div class="tm-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="message" class="tm-form-label">
                                        {{ __('messages.modal_message_label') }}
                                    </label>
                                    <textarea id="message" rows="3"
                                        class="form-control tm-form-control tm-textarea @error('message') is-invalid @enderror"
                                        wire:model="message"></textarea>
                                    @error('message')
                                        <div class="tm-error">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-muted small mt-2">
                                    {!! __('messages.agree_terms_contact', ['terms_url' => route('terms'), 'privacy_url' => route('privacy')]) !!}
                                </div>


                                @error('general')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <button type="button" class="btn btn-secondary" wire:click="closeModal">
                                        {{ __('messages.modal_cancel_button') }}
                                    </button>

                                    <button type="submit" class="btn tm-order-btn text-white" wire:loading.attr="disabled">
                                        <span wire:loading.remove>{{ __('messages.send') }}</span>
                                        <span wire:loading>{{ __('messages.sending') }}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>

            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
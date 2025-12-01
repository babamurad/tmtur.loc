@props(['days' => '10–14 days'])

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

                <!-- Required docs -->
                <h4 class="fw-semibold mb-3">{{ __('visa.docs_title') }}</h4>
                <div class="list-group list-group-flush mb-4">
                    <!-- passport -->
                    <div class="list-group-item px-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-passport text-primary me-3 mt-1"></i>
                            <div>
                                <h6 class="mb-1">{{ __('visa.passport.title') }}</h6>
                                <small class="text-muted">{{ __('visa.passport.hint') }}</small>
                            </div>
                        </div>
                    </div>
                    <!-- photo -->
                    <div class="list-group-item px-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-person-badge text-primary me-3 mt-1"></i>
                            <div>
                                <h6 class="mb-1">{{ __('visa.photo.title') }}</h6>
                                <small class="text-muted">{{ __('visa.photo.hint') }}</small>
                            </div>
                        </div>
                    </div>
                    <!-- questionnaire -->
                    <div class="list-group-item px-0">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-ui-checks text-primary me-3 mt-1"></i>
                            <div>
                                <h6 class="mb-1">{{ __('visa.questionnaire.title') }}</h6>
                                <ul class="small text-muted mb-0">
                                    @foreach(__('visa.questionnaire.fields') as $f)
                                        <li>{{ $f }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="d-flex align-items-center p-3 bg-light rounded mb-4">
                    <i class="bi bi-envelope-at-fill text-danger me-3 fs-4"></i>
                    <div>
                        <strong>{{ __('visa.email') }}</strong><br>
                        <a href="mailto:tmtourism24@gmail.com" class="text-decoration-none">tmtourism24@gmail.com</a>
                    </div>
                </div>

                <!-- Timeline -->
                <h4 class="fw-semibold mb-3">{{ __('visa.timeline') }}</h4>
                <p>{!! __('visa.timeline_txt', ['days' => '<span class="badge bg-success">'.$days.'</span>']) !!}</p>

                <!-- Where to get visa -->
                <h4 class="fw-semibold mb-3">{{ __('visa.where_title') }}</h4>
                <p>{{ __('visa.where_txt') }}</p>
                <ul class="mb-0">
                    <li>{!! __('visa.where_opt1') !!}</li>
                    <li>{!! __('visa.where_opt2') !!}</li>
                </ul>

            </div>
        </div>
    </div>
</section>
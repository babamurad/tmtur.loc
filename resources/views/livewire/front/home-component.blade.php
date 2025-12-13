<div>

    <!-- ========== ABOUT TURKMENISTAN — GETYOURGUIDE STYLE ========== -->
    <section class="py-5 bg-white" id="about">
        <div class="container py-4">

            <div class="row align-items-center gy-5">

                <!-- LEFT SIDE — TEXT -->
                <div class="col-lg-6">

                    <h2 class="fw-bold mb-4" style="font-size: 2rem;">
                        {{ __('about_g.title') }}
                    </h2>

                    <p class="text-muted mb-0 pb-0" style="font-size: 1.05rem; line-height: 1.6; text-indent: 1.5rem;">
                        {{ __('about_g.text1') }}
                    </p>

                    <p class="text-muted mb-4" style="font-size: 1.05rem; line-height: 1.6; text-indent: 1.5rem;">
                        {{ __('about_g.text2') }}
                    </p>

                    <h3>Почему путешественники выбирают TmTourism</h3>
                    <ul>
                        <li class="text-muted">Местная команда с реальным опытом в туризме</li>
                        <li class="text-muted">Помощь с визой, LOI и прохождением границы</li>
                        <li class="text-muted">Прозрачные цены без скрытых доплат</li>
                        <li class="text-muted">Небольшие группы и индивидуальный подход</li>
                    </ul>
                    <p class="text-muted"></p>


                    <!-- FEATURES -->
                    <!-- <div class="row g-3 mb-4">

                    <div class="col-6 d-flex align-items-center">
                        <i class="fas fa-sun text-warning mr-2"></i>
                        <span class="small">{{ __('about_g.fact1') }}</span>
                    </div>

                    <div class="col-6 d-flex align-items-center">
                        <i class="fas fa-mountain text-secondary mr-2"></i>
                        <span class="small">{{ __('about_g.fact2') }}</span>
                    </div>

                    <div class="col-6 d-flex align-items-center">
                        <i class="fas fa-city text-primary mr-2"></i>
                        <span class="small">{{ __('about_g.fact3') }}</span>
                    </div>

                    <div class="col-6 d-flex align-items-center">
                        <i class="fas fa-wifi text-danger mr-2"></i>
                        <span class="small">{{ __('about_g.fact4') }}</span>
                    </div>

                </div> -->

                    <!-- <a href="#tours" class="btn btn-danger px-4 py-2" style="border-radius: 10px;">
                    {{ __('about_g.btn') }}
                </a> -->

                </div>

                <!-- RIGHT SIDE — IMAGE GRID -->
                <div class="col-lg-6">
                    <div class="about-grid">

                        <div class="about-large">
                            <img src="/assets/images/tmfotos/i.webp" alt="Turkmenistan" />
                        </div>

                        <div class="about-small">
                            <img src="/assets/images/tmfotos/81.webp" alt="Turkmenistan" />
                        </div>

                        <div class="about-small">
                            <img src="/assets/images/tmfotos/i-1.webp" alt="Turkmenistan" />
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- ========== POPULAR TOURS – GETYOURGUIDE PREMIUM ========== -->
    <section id="tours" class="bg-light">
        <div class="container py-5">

            <h2 class="text-center mb-5 fs-2 fw-bold text-dark">
                {{ __('about.popular_tours') }}
            </h2>

            <div class="row g-4">

                @foreach($tours as $tour)

                    @php
                        $badges = ['Most Popular', 'Best Price', 'New Tour', 'Recommended', 'Local Favorite'];
                        $badge = $badges[array_rand($badges)];
                    @endphp

                    <div class="col-md-6 col-lg-4 mb-4">

                        <div class="card border-0 shadow tour-card-gyg h-100"
                            style="border-radius: 16px; overflow: hidden; transition: .25s;">

                            <!-- TOP IMAGE -->
                            <div class="position-relative">
                                <a href="{{ route('tours.show', $tour->slug) }}">
                                    <img src="{{ $tour->first_media_url }}" class="w-100"
                                        style="height: 260px; object-fit: cover;">
                                </a>

                                <!-- BADGE -->
                                <span class="tour-badge-gyg">{{ $badge }}</span>
                            </div>

                            <!-- BODY -->
                            <div class="card-body" style="padding: 1.25rem 1.25rem 0.5rem;">

                                <!-- TITLE -->
                                <a href="{{ route('tours.show', $tour->slug) }}" class="text-decoration-none text-dark">
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
                                @if($tour->groupsOpen->first())
                                    <div class="tour-price-box d-flex flex-column mb-3">

                                        <!-- Цена за 1 человека -->
                                        <div class="price-chip-single mb-1">
                                            <i class="fas fa-user mr-1"></i>
                                            1 {{ __('messages.person') ?? 'чел.' }}:
                                            <strong>${{ $tour->groupsOpen->first()->price_max }}</strong>
                                        </div>

                                        <!-- Цена за группу -->
                                        <div class="price-chip-group">
                                            <i class="fas fa-users mr-1"></i>
                                            {{ $tour->groupsOpen->first()->max_people }} {{ __('messages.people') ?? 'чел.' }}:
                                            <strong>${{ $tour->groupsOpen->first()->price_min }}</strong>
                                        </div>

                                    </div>
                                @endif


                            </div>

                            <!-- FOOTER -->
                            <div class="card-footer bg-white border-0 pb-4 px-3">
                                <a href="{{ route('tours.show', $tour->slug) }}" class="btn btn-danger w-100 py-2"
                                    style="border-radius: 12px; font-size: 1rem;">
                                    {{ __('messages.read_more') }}
                                </a>
                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

            <div class="text-center mt-4">
                <a href="{{ route('tours.category.index') }}" class="btn btn-danger btn-lg px-4 py-2"
                    style="border-radius: 50px;">
                    {{ __('messages.see_all') }}
                </a>
            </div>

        </div>
    </section>

    <!-- ========== ADVANTAGES — COLORED WEROAD ICONS ========== -->
    <section class="bg-light">
        <div class="container">

            <h2 class="text-center mb-5 fw-bold" style="font-size: 2.2rem;">
                {{ __('advantages.title') }}
            </h2>

            <div class="row g-4">
                @php
                    $items = [
                        ['icon' => 'fa-fire', 'color' => '#ff5a3c', 'title' => __('advantages.item1_title'), 'text' => __('advantages.item1_text')],
                        ['icon' => 'fa-archway', 'color' => '#1fb6ff', 'title' => __('advantages.item2_title'), 'text' => __('advantages.item2_text')],
                        ['icon' => 'fa-horse', 'color' => '#ffc82c', 'title' => __('advantages.item3_title'), 'text' => __('advantages.item3_text')],
                        ['icon' => 'fa-umbrella-beach', 'color' => '#7e5bef', 'title' => __('advantages.item4_title'), 'text' => __('advantages.item4_text')],
                        ['icon' => 'fa-utensils', 'color' => '#13ce66', 'title' => __('advantages.item5_title'), 'text' => __('advantages.item5_text')],
                        ['icon' => 'fa-spa', 'color' => '#ff7849', 'title' => __('advantages.item6_title'), 'text' => __('advantages.item6_text')],
                    ];
                @endphp

                @foreach($items as $item)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 border-0 shadow-sm adv-card">
                            <div class="card-body text-center">

                                <div class="adv-icon-circle mb-3" style="background: {{ $item['color'] }}20;">
                                    <i class="fa-solid {{ $item['icon'] }}" style="color: {{ $item['color'] }};"></i>
                                </div>

                                <h5 class="fw-bold mb-2" style="font-size: 1.2rem;">
                                    {{ $item['title'] }}
                                </h5>

                                <p class="text-muted small" style="line-height: 1.5;">
                                    {{ $item['text'] }}
                                </p>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>


    <!-- ========== GALLERY ========== -->
    <section class="bg-light">
        <div class="container pt-4">
            <h2 class="text-center mb-5">{{ __('about.photos_title') }}</h2>

            <div class="row g-3 gallery-item align-items-stretch justify-content-center">
                @foreach($fotos as $foto)
                    <div class="col-6 col-md-3 mb-2" style="cursor: pointer;">
                        <img src="{{ asset($foto->getFullUrlAttribute()) }}" class="img-fluid rounded shadow gallery-image"
                            alt="{{ $foto->tr('alt_text') }}" title="{{ $foto->tr('title') }}" data-toggle="modal"
                            data-target="#lightboxModal" data-img="{{ asset($foto->getFullUrlAttribute()) }}"
                            data-title="{{ $foto->tr('title') }}" data-location="{{ $foto->tr('location') }}"
                            data-photographer="{{ $foto->tr('photographer') }}"
                            data-description="{{ strip_tags($foto->tr('description')) }}">
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('galley') }}" class="btn btn-success">{{ __('about.see_all_photos') }}</a>
            </div>
        </div>

        <!-- ========== MODAL ========== -->
        <div class="modal fade" id="lightboxModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content bg-dark border-0">
                    <div class="modal-body p-0">
                        <button type="button" class="close text-white position-absolute"
                            style="right:15px;top:10px;z-index:1051;" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size:32px;">&times;</span>
                        </button>

                        <!-- Image -->
                        <img id="lightboxImg" src="" class="img-fluid w-100" alt=""
                            style="max-height: 70vh; object-fit: contain;">

                        <!-- Photo Information -->
                        <div class="p-4 text-white">
                            <h4 id="lightboxTitle" class="mb-3 font-weight-bold"></h4>

                            <div class="row mb-3">
                                <div class="col-md-6" id="lightboxLocationWrapper">
                                    <p class="mb-1">
                                        <i class="fas fa-map-marker-alt text-danger mr-2"></i>
                                        <span id="lightboxLocation" class="text-white-50"></span>
                                    </p>
                                </div>
                                <div class="col-md-6" id="lightboxPhotographerWrapper">
                                    <p class="mb-1">
                                        <i class="fas fa-camera text-primary mr-2"></i>
                                        <span id="lightboxPhotographer" class="text-white-50"></span>
                                    </p>
                                </div>
                            </div>

                            <div id="lightboxDescriptionWrapper">
                                <p id="lightboxDescription" class="text-white-50 mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- JS: обработчик должен быть подключён после jQuery + bootstrap.js -->
    @push('scripts')
        <script>
            // jQuery обработчик Bootstrap4
            $('#lightboxModal').on('show.bs.modal', function (event) {
                var trigger = $(event.relatedTarget);
                var imgSrc = trigger.data('img') || '';
                var title = trigger.data('title') || '';
                var location = trigger.data('location') || '';
                var photographer = trigger.data('photographer') || '';
                var description = trigger.data('description') || '';

                var modal = $(this);

                // Set image
                modal.find('#lightboxImg').attr('src', imgSrc);
                modal.find('#lightboxImg').attr('alt', title);

                // Set title
                modal.find('#lightboxTitle').text(title);

                // Set location (hide if empty)
                if (location) {
                    modal.find('#lightboxLocation').text(location);
                    modal.find('#lightboxLocationWrapper').show();
                } else {
                    modal.find('#lightboxLocationWrapper').hide();
                }

                // Set photographer (hide if empty)
                if (photographer) {
                    modal.find('#lightboxPhotographer').text(photographer);
                    modal.find('#lightboxPhotographerWrapper').show();
                } else {
                    modal.find('#lightboxPhotographerWrapper').hide();
                }

                // Set description (hide if empty)
                if (description) {
                    modal.find('#lightboxDescription').text(description);
                    modal.find('#lightboxDescriptionWrapper').show();
                } else {
                    modal.find('#lightboxDescriptionWrapper').hide();
                }
            });

            // Подчищаем при закрытии
            $('#lightboxModal').on('hidden.bs.modal', function () {
                $(this).find('#lightboxImg').attr('src', '');
                $(this).find('#lightboxTitle').text('');
                $(this).find('#lightboxLocation').text('');
                $(this).find('#lightboxPhotographer').text('');
                $(this).find('#lightboxDescription').text('');
            });
        </script>
    @endpush

    <!-- ========== FAQ (Bootstrap 4) ========== -->
    <section class="py-3 bg-light">
        <div class="container py-5">
            <h2 class="text-center mb-5">{{ __('faq.faq_title') }}</h2>

            <div class="row justify-content-center align-items-center">

                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('assets/images/faq/faq.webp') }}" alt="" class="img-fluid w-100 rounded">
                </div>
                <div class="col-lg-6">
                    <div id="faqAccordion" role="tablist" aria-multiselectable="true">

                        <!-- FAQ Item 1 -->
                        <div class="card mb-2 border-0 shadow-sm">
                            <div class="card-header bg-white" role="tab" id="faq1Head">
                                <h5 class="mb-0">
                                    <a class="btn btn-link text-dark text-decoration-none d-flex align-items-center justify-content-between w-100 collapsed"
                                        data-toggle="collapse" href="#faq1" aria-expanded="true" aria-controls="faq1">
                                        <i class="fas fa-question-circle text-primary mr-3"
                                            style="font-size: 1.25rem; min-width: 24px;"></i>
                                        <span>{{ __('faq.visa_question') }}</span>
                                    </a>
                                </h5>
                            </div>
                            <div id="faq1" class="collapse show" role="tabpanel" aria-labelledby="faq1Head"
                                data-parent="#faqAccordion">
                                <div class="card-body d-flex">
                                    <i class="fas fa-check-circle text-success mr-3 mt-1"
                                        style="font-size: 1.25rem; min-width: 24px;"></i>
                                    <div>{{ __('faq.visa_answer') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 2 -->
                        <div class="card mb-2 border-0 shadow-sm">
                            <div class="card-header bg-white" role="tab" id="faq2Head">
                                <h5 class="mb-0">
                                    <a class="btn btn-link text-dark text-decoration-none collapsed d-flex align-items-center justify-content-between w-100 collapsed"
                                        data-toggle="collapse" href="#faq2" aria-expanded="false" aria-controls="faq2">
                                        <i class="fas fa-question-circle text-primary mr-3"
                                            style="font-size: 1.25rem; min-width: 24px;"></i>
                                        <span>{{__('faq.darvaza_time')}}</span>
                                    </a>
                                </h5>
                            </div>
                            <div id="faq2" class="collapse" role="tabpanel" aria-labelledby="faq2Head"
                                data-parent="#faqAccordion">
                                <div class="card-body d-flex">
                                    <i class="fas fa-check-circle text-success mr-3 mt-1"
                                        style="font-size: 1.25rem; min-width: 24px;"></i>
                                    <div>{{__('faq.darvaza_answer')}}</div>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 3 -->
                        <div class="card mb-2 border-0 shadow-sm">
                            <div class="card-header bg-white" role="tab" id="faq3Head">
                                <h5 class="mb-0">
                                    <a class="btn btn-link text-dark text-decoration-none collapsed d-flex align-items-center justify-content-between w-100 collapsed"
                                        data-toggle="collapse" href="#faq3" aria-expanded="false" aria-controls="faq3">
                                        <i class="fas fa-question-circle text-primary mr-3"
                                            style="font-size: 1.25rem; min-width: 24px;"></i>
                                        <span>{{__('faq.hell_safe_q')}}</span>
                                    </a>
                                </h5>
                            </div>
                            <div id="faq3" class="collapse" role="tabpanel" aria-labelledby="faq3Head"
                                data-parent="#faqAccordion">
                                <div class="card-body d-flex">
                                    <i class="fas fa-check-circle text-success mr-3 mt-1"
                                        style="font-size: 1.25rem; min-width: 24px;"></i>
                                    <div>{{__('faq.hell_safe_a')}}</div>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 4 -->
                        <div class="card mb-2 border-0 shadow-sm">
                            <div class="card-header bg-white" role="tab" id="faq4Head">
                                <h5 class="mb-0">
                                    <a class="btn btn-link text-dark text-decoration-none collapsed d-flex align-items-center justify-content-between w-100"
                                        data-toggle="collapse" href="#faq4" aria-expanded="false" aria-controls="faq4">
                                        <i class="fas fa-question-circle text-primary me-3"
                                            style="font-size: 1.25rem; min-width: 24px;"></i>
                                        <span>{{ __('faq.hell_what_bring_q') }}</span>
                                    </a>
                                </h5>
                            </div>

                            <div id="faq4" class="collapse" role="tabpanel" aria-labelledby="faq4Head"
                                data-parent="#faqAccordion">
                                <div class="card-body d-flex">
                                    <i class="fas fa-check-circle text-success me-3 mt-1"
                                        style="font-size: 1.25rem; min-width: 24px;"></i>
                                    <div>{{ __('faq.hell_what_bring_a') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 5 -->
                        <div class="card mb-2 border-0 shadow-sm">
                            <div class="card-header bg-white" role="tab" id="faq5Head">
                                <h5 class="mb-0">
                                    <a class="btn btn-link text-dark text-decoration-none collapsed d-flex align-items-center justify-content-between w-100"
                                        data-toggle="collapse" href="#faq5" aria-expanded="false" aria-controls="faq5">
                                        <i class="fas fa-question-circle text-primary me-3"
                                            style="font-size: 1.25rem; min-width: 24px;"></i>
                                        <span>{{ __('faq.age_q') }}</span>
                                    </a>
                                </h5>
                            </div>
                            <div id="faq5" class="collapse" role="tabpanel" aria-labelledby="faq5Head"
                                data-parent="#faqAccordion">
                                <div class="card-body d-flex">
                                    <i class="fas fa-check-circle text-success me-3 mt-1"
                                        style="font-size: 1.25rem; min-width: 24px;"></i>
                                    <div>{{ __('faq.age_a') }}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
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
                            <i class="fas fa-shield-alt"></i>
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
                <a href="#tours" class="btn btn-danger px-4 py-2" style="border-radius: 10px;">
                    {{ __('safe.btn') }}
                </a>
            </div>

        </div>
    </section>


    {{--42270905--}}
    <!-- ========== CONTACTS ========== -->
    @livewire('front.contact-form-component')
</div>
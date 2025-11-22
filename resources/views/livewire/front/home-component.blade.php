<div>
    <!-- ========== ABOUT TURKMENISTAN ========== -->
<section id="about" class="py-5 bg-white">
    <div class="container px-4">
        <h2 class="text-center mb-5 fs-2 fw-bold text-dark">{{ __('about.title') }}</h2>

        <div class="row align-items-center g-5">
            {{-- Текстовая часть --}}
            <div class="col-md-6">
                <p class="mb-4">{{ __('about.lead1') }}</p>
                <p class="mb-4">{{ __('about.lead2') }}</p>

                <ul class="list-unstyled mb-4">
                    <li class="d-flex align-items-start mb-2">
                        <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                        <span>{{ __('about.sunny') }}</span>
                    </li>
                    <li class="d-flex align-items-start mb-2">
                        <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                        <span>{{ __('about.nature') }}</span>
                    </li>
                    <li class="d-flex align-items-start mb-2">
                        <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                        <span>{{ __('about.hospitable') }}</span>
                    </li>
                    <li class="d-flex align-items-start mb-2">
                        <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                        <span>{{ __('about.history') }}</span>
                    </li>
                </ul>

                <a href="#contact" class="btn btn-dark px-4 py-2 rounded-pill">{{ __('about.btn') }}</a>
            </div>

            {{-- Изображения --}}
            <div class="col-md-6">
                <div class="row g-3">
                        <div class="col-6">
                            <div class="overflow-hidden rounded shadow-sm">
                                <img src="{{ asset('assets/images/tmfotos/i (4).webp') }}" class="img-fluid w-100 h-100 object-fit-cover mb-2" alt="Туркменистан">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="overflow-hidden rounded shadow-sm">
                                <img src="{{ asset('assets/images/tmfotos/i.webp') }}" class="img-fluid w-100 h-100 object-fit-cover mb-2" alt="Туркменистан">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="overflow-hidden rounded shadow-sm">
                                <img src="{{ asset('assets/images/tmfotos/i (2).webp') }}" class="img-fluid w-100 h-100 object-fit-cover mb-2" alt="Туркменистан">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="overflow-hidden rounded shadow-sm">
                                <img src="{{ asset('assets/images/tmfotos/i (1).webp') }}" class="img-fluid w-100 h-100 object-fit-cover mb-2" alt="Туркменистан">
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- ========== TOURS ========== -->
    <section id="tours" class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="text-center mb-5">{{ __('about.popular_tours') }}</h2>
            <div class="row g-4">
                <!-- Card 1 -->
                @foreach($tours as $tour)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100 shadow">
                            <div class="position-relative">
                                <a href="{{ route('our-tours.show', $tour->slug) }}">
                                @if($tour->media)
                                    <img src="{{ asset('uploads/' . $tour->media->file_path) }}" class="card-img-top">
                                @else
                                    <img src="{{ asset('assets/images/tmfotos/default.jpg') }}" class="card-img-top">
                                @endif
                                </a>
                                {{--                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">HIT</span>--}}
                            </div>
                            <div class="card-body d-flex flex-column">
                                <a href="{{ route('our-tours.show', $tour->slug) }}">
                                <h5 class="card-title">{{ $tour->tr('title') }}</h5>
                                </a>
                                <p class="card-text small">{!! Str::words(strip_tags($tour->short_description), 20, '...') !!}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div><span class="fw-bold text-danger ms-2">{{ $tour->duration_days }} days</span></div>
                                    <div class="text-warning"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('our-tours.show', $tour) }}" class="btn btn-dark w-100 mt-2">Read more</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4"><a href="#contact" class="btn btn-danger btn-lg">See All</a></div>
        </div>
    </section>




    <!-- ========== GALLERY ========== -->
    <section class="bg-light">
        <div class="container pt-4">
            <h2 class="text-center mb-5">{{ __('about.photos_title') }}</h2>

            <div class="row g-3 gallery-item align-items-stretch justify-content-center">
                @foreach($fotos as $foto)
                    <div class="col-6 col-md-3 mb-2" style="cursor: pointer;">
                        <img src="{{ asset($foto->getFullUrlAttribute()) }}"
                             class="img-fluid rounded shadow gallery-image"
                             alt="{{ $foto->alt_text }}"
                             title="{{ $foto->title }}"
                             data-toggle="modal"
                             data-target="#lightboxModal"
                             data-img="{{ asset($foto->getFullUrlAttribute()) }}"
                             data-title="{{ $foto->title }}">
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
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body text-center p-0">
                        <button type="button" class="close text-white position-absolute" style="right:10px;top:6px;z-index:1051;" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size:28px;">&times;</span>
                        </button>

                        <img id="lightboxImg" src="" class="img-fluid rounded shadow" alt="">
                        <div id="lightboxTitle" class="text-center text-white mt-2"></div>
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
                var trigger = $(event.relatedTarget); // элемент, который открыл модал (картинка)
                var imgSrc = trigger.data('img') || '';
                var title = trigger.data('title') || '';

                var modal = $(this);
                modal.find('#lightboxImg').attr('src', imgSrc);
                modal.find('#lightboxImg').attr('alt', title);
                modal.find('#lightboxTitle').text(title);
            });

            // Подчищаем src при закрытии (опционально) — чтобы освободить память
            $('#lightboxModal').on('hidden.bs.modal', function () {
                $(this).find('#lightboxImg').attr('src', '');
                $(this).find('#lightboxTitle').text('');
            });
        </script>
    @endpush




    <!-- ========== FAQ (Bootstrap 4) ========== -->
    <section class="py-3 bg-light">
        <div class="container py-5">
            <h2 class="text-center mb-5">{{ __('faq.faq_title') }}</h2>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div id="faqAccordion" role="tablist" aria-multiselectable="true">

                        <!-- FAQ Item 1 -->
                        <div class="card mb-2 border-0 shadow-sm">
                            <div class="card-header bg-white" role="tab" id="faq1Head">
                                <h5 class="mb-0">
                                    <a class="btn btn-link text-dark text-decoration-none d-flex align-items-center justify-content-between w-100 collapsed"
                                       data-toggle="collapse" href="#faq1" aria-expanded="true" aria-controls="faq1">
                                        <i class="fas fa-question-circle text-primary mr-3" style="font-size: 1.25rem; min-width: 24px;"></i>
                                        <span>{{ __('faq.visa_question') }}</span>
                                    </a>
                                </h5>
                            </div>
                            <div id="faq1" class="collapse show" role="tabpanel" aria-labelledby="faq1Head" data-parent="#faqAccordion">
                                <div class="card-body d-flex">
                                    <i class="fas fa-check-circle text-success mr-3 mt-1" style="font-size: 1.25rem; min-width: 24px;"></i>
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
                                        <i class="fas fa-question-circle text-primary mr-3" style="font-size: 1.25rem; min-width: 24px;"></i>
                                        <span>{{__('faq.darvaza_time')}}</span>
                                    </a>
                                </h5>
                            </div>
                            <div id="faq2" class="collapse" role="tabpanel" aria-labelledby="faq2Head" data-parent="#faqAccordion">
                                <div class="card-body d-flex">
                                    <i class="fas fa-check-circle text-success mr-3 mt-1" style="font-size: 1.25rem; min-width: 24px;"></i>
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
                                        <i class="fas fa-question-circle text-primary mr-3" style="font-size: 1.25rem; min-width: 24px;"></i>
                                        <span>{{__('faq.hell_safe_q')}}</span>
                                    </a>
                                </h5>
                            </div>
                            <div id="faq3" class="collapse" role="tabpanel" aria-labelledby="faq3Head" data-parent="#faqAccordion">
                                <div class="card-body d-flex">
                                    <i class="fas fa-check-circle text-success mr-3 mt-1" style="font-size: 1.25rem; min-width: 24px;"></i>
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
                                        <i class="fas fa-question-circle text-primary me-3" style="font-size: 1.25rem; min-width: 24px;"></i>
                                        <span>{{ __('faq.hell_what_bring_q') }}</span>
                                    </a>
                                </h5>
                            </div>

                            <div id="faq4" class="collapse" role="tabpanel" aria-labelledby="faq4Head" data-parent="#faqAccordion">
                                <div class="card-body d-flex">
                                    <i class="fas fa-check-circle text-success me-3 mt-1" style="font-size: 1.25rem; min-width: 24px;"></i>
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
                                        <i class="fas fa-question-circle text-primary me-3" style="font-size: 1.25rem; min-width: 24px;"></i>
                                        <span>{{ __('faq.age_q') }}</span>
                                    </a>
                                </h5>
                            </div>
                            <div id="faq5" class="collapse" role="tabpanel" aria-labelledby="faq5Head" data-parent="#faqAccordion">
                                <div class="card-body d-flex">
                                    <i class="fas fa-check-circle text-success me-3 mt-1" style="font-size: 1.25rem; min-width: 24px;"></i>
                                    <div>{{ __('faq.age_a') }}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

{{--42270905--}}
    <!-- ========== CONTACTS ========== -->
    @livewire('front.contact-form-component')
</div>

<div>
    
<section class="py-5 bg-white" id="about">
  <div class="container py-4">
    <div class="row align-items-center gy-5">

      <!-- LEFT SIDE — TEXT -->
      <div class="col-lg-6">
        <h2 class="fw-bold mb-4" style="font-size: 2rem; color: #212529;">
          Discover Turkmenistan
        </h2>

        <p class="text-muted mb-3" style="font-size: 1.05rem; line-height: 1.7; text-indent: 1.5rem;">
          A land of shining cities, ancient civilizations and the endless sands of the Karakum Desert — where tradition and modernity meet.
        </p>

        <p class="text-muted mb-4" style="font-size: 1.05rem; line-height: 1.7; text-indent: 1.5rem;">
          From the legendary Darvaza Gas Crater to marble Ashgabat and the ancient ruins of Merv, Turkmenistan offers unforgettable experiences.
        </p>

        <h3 class="fw-bold mb-3" style="color: #212529;">Почему путешественники выбирают TmTourism</h3>

        <ul class="about-features-list">
          <li>Местная команда с реальным опытом в туризме</li>
          <li>Помощь с визой, LOI и прохождением границы</li>
          <li>Прозрачные цены без скрытых доплат</li>
          <li>Небольшие группы и индивидуальный подход</li>
        </ul>
      </div>

      <!-- RIGHT SIDE — IMAGE GRID -->
      <div class="col-lg-6">
        <div class="about-grid">
          <div class="about-large">
            <img src="/assets/images/tmfotos/i.webp" alt="Turkmenistan">
          </div>
          <div class="about-small">
            <img src="/assets/images/tmfotos/81.webp" alt="Turkmenistan">
          </div>
          <div class="about-small">
            <img src="/assets/images/tmfotos/i-1.webp" alt="Turkmenistan">
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

    <!-- ========== POPULAR TOURS – GETYOURGUIDE PREMIUM ========== -->
    <section id="tours" class="bg-light">
        <div class="container py-5">

            <!-- SECTION HEADER -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-3" style="font-size: 2rem;">
                        {{ __('messages.home_popular_title') ?? 'Popular tours in Turkmenistan' }}
                    </h2>
                    <p class="text-muted mb-0" style="font-size: 1.05rem; max-width: 680px;">
                        {{ __('messages.home_popular_subtitle') ?? 'Handpicked group & private tours carefully crafted by local experts.' }}
                    </p>
                </div>
                <div class="col-lg-4 d-flex align-items-center justify-content-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('tours.category.index') }}" class="btn btn-outline-secondary btn-sm">
                        {{ __('messages.view_all') ?? 'View all tours' }}
                    </a>
                </div>
            </div>

            <!-- TOURS GRID -->
            <div class="row">
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
                                    <img src="{{ $tour->first_media_url }}" class="w-100" alt="{{ $tour->tr('title') }}"
                                        loading="lazy">
                                </a>

                                <!-- BADGE -->
                                <span class="tour-badge-gyg">{{ $badge }}</span>

                                <!-- LOCATION CHIP -->
                                <span class="tour-location-chip">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $tour->tr('location_short') ?? $tour->tr('location') ?? 'Turkmenistan' }}
                                </span>

                                <!-- RATING CHIP (STATIC / PLACEHOLDER OR FROM DB) -->
                                <span class="rating-chip">
                                    <i class="fas fa-star"></i>
                                    4.9 <span class="ml-1 small">({{ rand(18, 57) }} reviews)</span>
                                </span>
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

                                <!-- DURATION & TYPE -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex flex-column">
                                        <span class="small text-muted">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $tour->days ?? '2-3' }} {{ __('messages.days_label') ?? 'days' }}
                                        </span>
                                        <span class="small text-muted">
                                            <i class="fas fa-users mr-1"></i>
                                            {{ __('messages.small_group') ?? 'Small group tour' }}
                                        </span>
                                    </div>

                                    <!-- PRICE (from tour or group) -->
                                    @if($tour->groupsOpen->first())
                                        <div class="d-flex flex-column mb-3">

                                            <!-- Цена за 1 человека -->
                                            <div class="price-chip-single mb-1">
                                                <i class="fas fa-user mr-1"></i>
                                                1 {{ __('messages.person') ?? 'чел.' }}:
                                                <strong>${{ $tour->groupsOpen->first()->price_max }}</strong>
                                            </div>

                                            <!-- Цена за группу -->
                                            <div class="price-chip-group">
                                                <i class="fas fa-users mr-1"></i>
                                                {{ $tour->groupsOpen->first()->max_people }}
                                                {{ __('messages.people') ?? 'чел.' }}:
                                                <strong>${{ $tour->groupsOpen->first()->price_min }}</strong>
                                            </div>

                                        </div>
                                    @endif


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

                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- ========== BORDER CROSSING & VISA SUPPORT – 3 STEPS ========== -->
    <section class="py-5 bg-white" id="borders">
        <div class="container py-4">

            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3" style="font-size: 2rem;">
                    {{ __('home_borders.title') ?? 'Visa, LOI & Border crossing support' }}
                </h2>
                <p class="text-muted mb-0" style="font-size: 1.05rem; max-width: 780px; margin: 0 auto;">
                    {{ __('home_borders.subtitle') ?? 'We help you get your Letter of Invitation (LOI), arrange visas and cross Turkmen borders smoothly.' }}
                </p>
            </div>

            <div class="row">
                {{-- Карточка 1: LOI --}}
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 safe-pill" style="border-radius: 16px;">
                        <div class="card-body text-center">
                            <div class="safe-icon mb-3">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <h5 class="fw-bold mb-2">
                                {{ __('home_borders.item1_title') ?? 'LOI (Letter of Invitation)' }}
                            </h5>
                            <p class="text-muted small mb-0">
                                {!! __('home_borders.item1_text')
    ?? 'We prepare your Letter of Invitation and advise which visa type fits your route and nationality.' !!}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Карточка 2: Виза --}}
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 safe-pill" style="border-radius: 16px;">
                        <div class="card-body text-center">
                            <div class="safe-icon mb-3">
                                <i class="fas fa-passport"></i>
                            </div>
                            <h5 class="fw-bold mb-2">
                                {{ __('home_borders.item2_title') ?? 'Visa support' }}
                            </h5>
                            <p class="text-muted small mb-0">
                                {!! __('home_borders.item2_text')
    ?? 'We guide you through visa-on-arrival or embassy procedures and provide all required documents.' !!}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Карточка 3: Граница --}}
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 safe-pill" style="border-radius: 16px;">
                        <div class="card-body text-center">
                            <div class="safe-icon mb-3">
                                <i class="fas fa-route"></i>
                            </div>
                            <h5 class="fw-bold mb-2">
                                {{ __('home_borders.item3_title') ?? 'Border crossing & transfers' }}
                            </h5>
                            <p class="text-muted small mb-0">
                                {!! __('home_borders.item3_text')
    ?? 'We arrange smooth crossings at Farap, Shavat, Kunya-Urgench, Howdan and other checkpoints with local drivers and guides.' !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('visa') }}" class="btn btn-danger px-4 py-2">
                    {{ __('home_borders.btn') ?? 'Learn more about visa & borders' }}
                </a>
            </div>

        </div>
    </section>



    <!-- ========== GALLERY / EXPERIENCES ========== -->
    <section class="py-5 bg-light" id="gallery">
        <div class="container py-4">

            <div class="text-center mb-4">
                <h2 class="fw-bold mb-3" style="font-size: 2rem;">
                    {{ __('home_gallery.title') ?? 'Real experiences from our tours' }}
                </h2>
                <p class="text-muted mb-0" style="font-size: 1.05rem; max-width: 780px; margin: 0 auto;">
                    {{ __('home_gallery.subtitle') ?? 'All photos are from real trips with our guests at Darvaza, Yangykala, Ashgabat, Koytendag and other destinations.' }}
                </p>
            </div>

            <div class="row">
                @foreach($fotos as $foto)
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="home-gallery-thumb">
                            <img src="{{ asset($foto->getFullUrlAttribute()) }}"
                                alt="{{ $foto->tr('title') ?? 'Turkmenistan tour' }}" loading="lazy">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('gallery') }}" class="btn btn-outline-secondary btn-sm">
                    {{ __('home_gallery.btn') ?? 'Open full gallery' }}
                </a>
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
                            <i class="fas fa-route"></i>
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
                <a href="{{ route('tours.category.index')}}" class="btn btn-danger px-4 py-2"
                    style="border-radius: 10px;">
                    {{ __('safe.btn') }}
                </a>
            </div>

        </div>
    </section>


    {{--42270905--}}
    <!-- ========== CONTACTS ========== -->
    @livewire('front.contact-form-component')
</div>
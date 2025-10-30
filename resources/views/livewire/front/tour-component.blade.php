<div>
    <section id="darwaza" class="py-5">
        <div class="container py-5">
            <h2 class="text-center mb-5">{{ $selectedTour->title }}</h2>
            <div class="row gy-4 align-items-center">
                <div class="col-md-6 order-2 order-md-1">
                    {{ $selectedTour->description }}
                    <br>
                    <a href="#tours" class="btn btn-danger mt-3">Book a tour to the Gates of Hell</a>
                </div>
                <div class="col-md-6 order-1 order-md-2">
                    <div class="position-relative">
                        @if($selectedTour->media)
                            <img class="img-fluid rounded" src="{{ asset('uploads' . '/' . $selectedTour->media->file_path) }}">
                        @else
                            <img class="img-fluid rounded" src="{{ asset('assets/images/tmfotos/default.jpg') }}">
                        @endif
                        <div class="position-absolute bottom-0 start-0 p-3 text-white">
                            <h5 class="mb-0">“You have to see it with your own eyes!”</h5>
                            <small>— Mark, traveler from Germany</small>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- ========== TOURS ========== -->
    <section id="tours" class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="text-center mb-5">Our popular tours</h2>
            <div class="row g-4">
                <!-- Card 1 -->
                @foreach($tours as $tour)
                    <div class="col-md-6 col-lg-4 mb-2">
                        <div class="card h-100 shadow">
                            <div class="position-relative">
                                @if($tour->media && !empty($tour->media->file_path) && file_exists(public_path('uploads/' . $tour->media->file_path)))
                                    <img src="{{ asset('uploads/' . $tour->media->file_path) }}"
                                         alt="{{ $tour->title }}"
                                         class="card-img-top">
                                @else
                                    <img src="{{ asset('assets/images/tmfotos/default.jpg') }}"
                                         alt="{{ $tour->title }} - Default image"
                                         class="card-img-top">
                                @endif
{{--                                <span class="badge bg-danger position-absolute top-0 end-0 m-2"--}}
{{--                                      aria-label="Popular tour">HIT</span>--}}
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $tour->title }}</h5>
                                <p class="card-text small">{{ $tour->description }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div>
                            <span class="fw-bold text-danger ms-2">
                                {{ $tour->duration_days }} {{ $tour->duration_days == 1 ? 'day' : 'days' }}
                            </span>
                                    </div>
                                    <div class="text-warning">
                                        @for($i = 0; $i < 5; $i++)
                                            <i class="fa-solid {{ $i < ($tour->rating ?? 0) ? 'fa-star' : 'fa-star-o' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('tours.show', $tour->id) }}"
                                   class="btn btn-dark w-100 mt-2">
                                    Read more
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4"><a href="#contact" class="btn btn-danger btn-lg">I want a private tour</a></div>
        </div>
    </section>
</div>

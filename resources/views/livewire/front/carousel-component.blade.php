<!-- ========== HERO-CAROUSEL ========== -->
<section id="home-carousel" class="carousel slide carousel-fade" data-ride="carousel">
    <!-- Индикаторы -->
    <ol class="carousel-indicators">
        @foreach($carousels as $carousel)
            <li data-target="#home-carousel" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}">
            </li>
        @endforeach
    </ol>

    <!-- Слайды -->
    <div class="carousel-inner">
        @foreach($carousels as $carousel)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-interval="5000"
                style="background-image: url({{ asset('uploads/' . $carousel->image) }}); background-size: cover; background-position: center;">
                <div class="carousel-caption text-center">
                    <h1 class="display-3 font-weight-bold">{{ $carousel->tr('title') }}</h1>
                    <p class="lead mb-4">{{ $carousel->tr('description') }}</p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center">
                        <a href="{{ route('tours.category.index') }}"
                            class="btn btn-primary rounded">{{ $carousel->tr('button_text') }}</a>
                        <a href="{{ route('front.tour-groups') }}"
                            class="btn btn-outline-light rounded">{{ __('All Tours') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Стрелки -->
    <a class="carousel-control-prev" href="#home-carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#home-carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</section>
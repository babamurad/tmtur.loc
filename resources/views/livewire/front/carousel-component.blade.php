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
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-interval="5000" style="position: relative;">
                @php
                    $extension = pathinfo($carousel->image, PATHINFO_EXTENSION);
                    $filename = pathinfo($carousel->image, PATHINFO_FILENAME);
                    $directory = dirname($carousel->image);
                    $directory = $directory === '.' ? '' : $directory . '/';
                    
                    // WebP variants
                    $mobileWebp = $directory . $filename . '_mobile.webp';
                    $desktopWebp = $directory . $filename . '_desktop.webp';
                    
                    // Check existence (optional validation, but assuming they exist if regenerated)
                    // For performance we might assume they exist or check via Storage which is slow in loop.
                    // Let's assume they exist if the command was run.
                    // But to be safe, we can check or fallback. 
                    // Given this is frontend, file_exists check on every request is bad.
                    // Better to blindly link if we are sure, or check existence if critical.
                    // Let's assume they exist.
                    
                    $mobileUrl = asset('uploads/' . $mobileWebp);
                    $desktopUrl = asset('uploads/' . $desktopWebp);
                    $originalUrl = asset('uploads/' . $carousel->image);
                @endphp
                
                <picture style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;">
                    <!-- Mobile WebP -->
                    <source media="(max-width: 768px)" srcset="{{ $mobileUrl }}" type="image/webp">
                    <!-- Desktop WebP -->
                    <source srcset="{{ $desktopUrl }}" type="image/webp">
                    
                    <!-- Fallback -->
                    <img src="{{ $originalUrl }}" 
                         alt="{{ $carousel->tr('title') }}"
                         style="width: 100%; height: 100%; object-fit: cover;"
                         @if($loop->first) loading="eager" fetchpriority="high" @else loading="lazy" @endif
                    >
                </picture>

                <div class="carousel-caption text-center" style="position: relative; z-index: 1; left: 0; right: 0; top:20%;">
                    <h2 class="display-3 font-weight-bold">{{ $carousel->tr('title') }}</h2>
                    <p class="lead mb-4">{{ $carousel->tr('description') }}</p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center">
                        <a href="{{ route('tours.category.index') }}"
                            class="btn btn-primary rounded">{{ __('All Tours') }}</a>
                        <a href="{{ route('front.tour-groups') }}"
                            class="btn btn-outline-light rounded">{{ __('By Dates') }}</a>
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
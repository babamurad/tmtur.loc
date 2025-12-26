<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Optimized Google Tag Manager & Analytics (Lazy Load) -->
    <script>
        // Init dataLayer immediately
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        
        // Record start time and config immediately
        dataLayer.push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
        gtag('js', new Date());
        gtag('config', 'G-C5C6D1TJJW');
        
        // Lazy load function
        function loadAnalytics() {
             if (window.analyticsLoaded) return;
             window.analyticsLoaded = true;

            // Load GTag Script
            var s1 = document.createElement('script');
            s1.async = true;
            s1.src = 'https://www.googletagmanager.com/gtag/js?id=G-C5C6D1TJJW';
            document.head.appendChild(s1);

            // Load GTM Script
            var s2 = document.createElement('script');
            s2.async = true;
            s2.src = 'https://www.googletagmanager.com/gtm.js?id=GTM-TJZ6LF4Z';
            document.head.appendChild(s2);
        }

        // Trigger on interaction or timeout
        var events = ["mouseover", "keydown", "touchstart", "touchmove", "wheel"];
        events.forEach(function(e) {
            window.addEventListener(e, loadAnalytics, { passive: true, once: true });
        });
        
        setTimeout(loadAnalytics, 4000);
    </script>

    <!-- Start cookieyes banner -->
    @if(config('app.env') === 'production')
        <script id="cookieyes" type="text/javascript"
            src="https://cdn-cookieyes.com/client_data/bfb64a58994c32d4e86c363b60b99a9e/script.js" defer></script>
    @endif
    <!-- End cookieyes banner -->



    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJZ6LF4Z" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    {!! SEO::generate() !!}

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🐪</text></svg>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"
        media="print" onload="this.media='all'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    </noscript>

    <!-- FontAwesome -->
    {{--
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            padding-top: 72px;
            /* примерная высота навбара */
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: radial-gradient(circle at 20% 20%, rgba(99, 102, 241, 0.06), transparent 30%),
                radial-gradient(circle at 80% 0%, rgba(45, 212, 191, 0.08), transparent 32%),
                linear-gradient(180deg, #f7f8fb 0%, #f0f4ff 100%);
            color: #1f2937;
        }

        .fa-fire {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        body.loading {
            opacity: 0.7;
            pointer-events: none;
            cursor: wait;
        }
    </style>
    @stack('quill-css')
</head>

<body data-spy="scroll" data-target="#mainNav">

    <!-- ========== НАВБАР ========== -->
    @livewire('front.navbar-component')

    @if (!isset($hideCarousel) || !$hideCarousel)
        @livewire('front.carousel-component')
    @endif

    {{ $slot }}

    <!-- ========== FOOTER ========== -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa-solid fa-fire text-danger mr-2"></i><span class="font-weight-bold">TmTourism</span>
                    </div>
                    <p class="small mb-0">{{ __('layout.footer_description') }}</p>
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bold mb-2">{{ __('layout.quick_links') }}</div>
                    <ul class="list-unstyled small">
                        <li><a href="/#home" class="text-white-50">{{ __('menu.home') }}</a></li>
                        <li><a href="/#about" class="text-white-50">{{ __('menu.about') }}</a></li>
                        <li><a href="/#tours" class="text-white-50">{{ __('menu.tours') }}</a></li>
                        <li><a href="/#visa" class="text-white-50">{{ __('menu.visa') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bold mb-2">{{ __('layout.quick_links') }}</div>
                    <ul class="list-unstyled small">
                        <li><a href="/#darwaza" class="text-white-50">{{ __('menu.darwaza') }}</a></li>
                        <li><a href="/#contact" class="text-white-50">{{ __('menu.contact') }}</a></li>
                        <li><a href="{{ route('gallery') }}" class="text-white-50">{{ __('menu.gallery') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    @livewire('front.newsletter-subscription-component')
                </div>
                <div class="col-md-3">
                    <div class="font-weight-bold mb-2">{{ __('layout.follow_us') }}</div>
                    @livewire('footer-social-links')
                </div>
            </div>
            <hr class="my-3 bg-white">
            <div class="text-center small text-white-50">&copy; 2025 {{ __('layout.copyright') }}</div>
        </div>
    </footer>

    <!-- ========== SCRIPTS ========== -->
    <!-- Scripts loaded via Vite -->
    <script src="{{ asset('js/mdb.min.js') }}" defer></script>

    <script>
        // Animation init
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof WOW !== 'undefined') {
                new WOW().init();
            }
        });
    </script>

    <script>
        // Функция для инициализации Bootstrap компонентов
        function initBootstrapComponents() {
            // Реинициализация всех dropdown элементов (только тех, что используют data-toggle)
            $('.dropdown-toggle[data-toggle="dropdown"]').each(function () {
                $(this).dropdown();
            });

            // Реинициализация WOW анимаций
            if (typeof WOW !== 'undefined') {
                new WOW().init();
            }

            // Закрытие мобильного меню при клике на ссылку
            $('.navbar-collapse a').on('click', function (e) {
                // Не закрывать для dropdown toggle
                if (!$(this).hasClass('dropdown-toggle')) {
                    var navbar = $('.navbar-collapse');
                    if (navbar.hasClass('show')) {
                        navbar.collapse('hide');
                    }
                }
            });
        }

        // Инициализация при первой загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof $ !== 'undefined') {
                initBootstrapComponents();
            }
        });

        // Реинициализация после навигации Livewire
        document.addEventListener('livewire:navigated', function () {
            initBootstrapComponents();
        });
    </script>

    <script>
        document.addEventListener('click', function (e) {
            // Проверяем, что кликнули по якорной ссылке
            if (e.target.matches('a[href^="#"]')) {
                const anchor = e.target;
                if (anchor.hasAttribute('data-toggle')) return;

                const href = anchor.getAttribute('href');
                if (href === '#' || href === '#home') return;

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();

                    const navbar = document.getElementById('mainNav');
                    const navbarHeight = navbar ? navbar.offsetHeight : 0;

                    const targetPosition = target.getBoundingClientRect().top;
                    const offsetPosition = window.pageYOffset + targetPosition - navbarHeight;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });

                    history.pushState(null, null, href);
                }
            }
        });
    </script>

    <script>
        let lastKnownScrollPosition = 0;
        let ticking = false;

        function updateNavbarState(scrollPos) {
            var navbar = document.getElementById('mainNav');
            if (!navbar) return;

            if (scrollPos > 10) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        }

        document.addEventListener('scroll', function(e) {
            lastKnownScrollPosition = window.scrollY;

            if (!ticking) {
                window.requestAnimationFrame(function() {
                    updateNavbarState(lastKnownScrollPosition);
                    ticking = false;
                });

                ticking = true;
            }
        });

        // Initial check
        document.addEventListener('DOMContentLoaded', function() {
            updateNavbarState(window.scrollY);
        });
        
        // Check on navigation
        document.addEventListener('livewire:navigated', function() {
            updateNavbarState(window.scrollY);
        });
    </script>


    @stack('quill-js')
    @stack('scripts')

</body>

</html>
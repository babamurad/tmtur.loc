<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-C5C6D1TJJW"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-C5C6D1TJJW');
    </script>

<!-- Start cookieyes banner --> 
 <script id="cookieyes" type="text/javascript" src="https://cdn-cookieyes.com/client_data/bfb64a58994c32d4e86c363b60b99a9e/script.js"></script> 
 <!-- End cookieyes banner -->

 <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TJZ6LF4Z');</script>
<!-- End Google Tag Manager -->

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJZ6LF4Z"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
 
  <meta charset="utf-8">
  <title>{{ $title ?? __('layout.meta_title') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🐪</text></svg>">

  <!-- Bootstrap 4.6 CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mdb-pro.min.css') }}">

    <!-- FontAwesome -->
{{--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Boxicons -->
{{--  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">--}}

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            padding-top: 60px; /* примерная высота навбара */
        }
        .fa-fire {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        body.loading {
            opacity: 0.7;
            pointer-events: none;
            cursor: wait;
        }
    </style>
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
                    <li><a href="{{ route('galley') }}" class="text-white-50" wire:navigate>{{ __('menu.gallery') }}</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <div class="font-weight-bold mb-2">{{ __('layout.subscribe_newsletter') }}</div>
                <form class="form-inline">
                    <input type="email" class="form-control form-control-sm mr-2" placeholder="{{ __('layout.your_email') }}" required>
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        <hr class="my-3 bg-white">
        <div class="text-center small text-white-50">&copy; 2025 {{ __('layout.copyright') }}</div>
    </div>
</footer>

<!-- ========== SCRIPTS ========== -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/mdb.min.js') }}"></script>

<script>
    // Animation init
    new WOW().init();
</script>

<script>
    // Функция для инициализации Bootstrap компонентов
    function initBootstrapComponents() {
        // Реинициализация всех dropdown элементов
        $('.dropdown-toggle').dropdown();
        
        // Реинициализация WOW анимаций
        if (typeof WOW !== 'undefined') {
            new WOW().init();
        }
        
        // Закрытие мобильного меню при клике на ссылку
        $('.navbar-collapse a').on('click', function(e) {
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
    $(document).ready(function() {
        initBootstrapComponents();
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

@stack('scripts')

</body>
</html>

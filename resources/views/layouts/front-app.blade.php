<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Туркменистан — Земля Огня и Тайн | TurkmenTravel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🐪</text></svg>">

  <!-- Bootstrap 4.6 CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mdb-pro.min.css') }}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

  <!-- Boxicons -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body data-spy="scroll" data-target="#mainNav">

<!-- ========== НАВБАР ========== -->
<nav id="mainNav" class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand font-weight-bold" href="/#home">
      <i class="fa-solid fa-fire text-danger mr-2"></i>TmTourism
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="/#home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/#about">About Turkmenistan</a></li>
        <li class="nav-item"><a class="nav-link" href="/#tours">Tours</a></li>
        <li class="nav-item"><a class="nav-link" href="/#visa">Visa</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">Blog</a></li>
        <li class="nav-item"><a class="nav-link" href="/#darwaza">Darvaza</a></li>
        <li class="nav-item"><a class="nav-link" href="/#contact">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

@if (!isset($hideCarousel) || !$hideCarousel)
    @livewire('front.carousel-component')
@endif

{{ $slot }}

<!-- ========== FOOTER ========== -->
<footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-fire text-danger mr-2"></i><span class="font-weight-bold">TmTourism</span>
                </div>
                <p class="small mb-0">Your reliable guide to amazing Turkmenistan.</p>
            </div>
            <div class="col-md-4">
                <div class="font-weight-bold mb-2">Quick links</div>
                <ul class="list-unstyled small">
                    <li><a href="#home" class="text-white-50">Home</a></li>
                    <li><a href="#about" class="text-white-50">About Turkmenistan</a></li>
                    <li><a href="#tours" class="text-white-50">Tours</a></li>
                    <li><a href="#visa" class="text-white-50">Visa</a></li>
                    <li><a href="#darwaza" class="text-white-50">Darvaza</a></li>
                    <li><a href="#contact" class="text-white-50">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="font-weight-bold mb-2">Subscribe to newsletter</div>
                <form class="form-inline">
                    <input type="email" class="form-control form-control-sm mr-2" placeholder="Your email" required>
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        <hr class="my-3 bg-white">
        <div class="text-center small text-white-50">&copy; 2025 TmTourism. All rights reserved.</div>
    </div>
</footer>

<!-- ========== SCRIPTS ========== -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/mdb.min.js') }}"></script>

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

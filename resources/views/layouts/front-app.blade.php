<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Туркменистан — Земля Огня и Тайн | TurkmenTravel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🐪</text></svg>">

  <!-- Bootstrap 5.3 -->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body data-bs-spy="scroll" data-bs-target="#mainNav">

<!-- ========== НАВБАР ========== -->
<nav id="mainNav" class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#home">
      <i class="fa-solid fa-fire text-danger me-2"></i>TurkmenTravel
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="#home">Главная</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">О Туркменистане</a></li>
        <li class="nav-item"><a class="nav-link" href="#tours">Туры</a></li>
        <li class="nav-item"><a class="nav-link" href="#darwaza">Дарваза</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Контакты</a></li>
      </ul>
    </div>
  </div>
</nav>

@livewire('front.carousel-component')

{{ $slot }}

<!-- ========== FOOTER ========== -->
<footer class="bg-dark text-white py-4">
  <div class="container">
    <div class="row gy-3">
      <div class="col-md-4">
        <div class="d-flex align-items-center mb-2">
          <i class="fa-solid fa-fire text-danger me-2"></i><span class="fw-bold">TmTourism</span>
        </div>
        <p class="small mb-0">Ваш надёжный гид по удивительному Туркменистану.</p>
      </div>
      <div class="col-md-4">
        <div class="fw-bold mb-2">Быстрые ссылки</div>
        <ul class="list-unstyled small">
          <li><a href="#home" class="text-white-50">Главная</a></li>
          <li><a href="#about" class="text-white-50">О Туркменистане</a></li>
          <li><a href="#tours" class="text-white-50">Туры</a></li>
          <li><a href="#darwaza" class="text-white-50">Дарваза</a></li>
          <li><a href="#contact" class="text-white-50">Контакты</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <div class="fw-bold mb-2">Подписаться на рассылку</div>
        <form class="d-flex"><input type="email" class="form-control form-control-sm me-2" placeholder="Ваш email" required><button class="btn btn-sm btn-danger"><i class="fa-solid fa-paper-plane"></i></button></form>
      </div>
    </div>
    <hr class="my-3 bg-white-50">
    <div class="text-center small text-white-50">&copy; 2023 TurkmenTravel. Все права защищены.</div>
  </div>
</footer>

<!-- ========== SCRIPTS ========== -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- 3. jQuery (обязательно ДО bootstrap.js) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- 4. Popper.js 1.16 -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- 5. Bootstrap 4 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script>
  // Smooth-scroll для якорей
  document.querySelectorAll('a[href^="#"]').forEach(anchor=>{
    anchor.addEventListener('click',function(e){
      e.preventDefault();
      const tgt=document.querySelector(this.getAttribute('href'));
      if(tgt) tgt.scrollIntoView({behavior:'smooth'});
    });
  });
  // Простая отправка формы
  document.getElementById('cta-form').addEventListener('submit',function(e){
    e.preventDefault();
    alert('Спасибо за заявку! Мы свяжемся в ближайшее время.');
    this.reset();
  });
</script>
</body>
</html>

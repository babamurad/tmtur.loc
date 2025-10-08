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

  <link rel="stylesheet" href="css/style.css">

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

<!-- ========== О ТУРКМЕНИСТАНЕ ========== -->
<section id="about" class="py-5">
  <div class="container py-5">
    <h2 class="text-center mb-5">Туркменистан — страна контрастов</h2>
    <div class="row align-items-center gy-4">
      <div class="col-md-6">
        <p class="mb-3">Туркменистан — уникальная страна, где древние традиции встречаются с современностью, а бескрайние пустыни соседствуют с мраморными городами.</p>
        <ul class="list-unstyled">
          <li class="mb-2"><i class="fa-solid fa-check-circle text-success me-2"></i>Более 300 солнечных дней в году</li>
          <li class="mb-2"><i class="fa-solid fa-check-circle text-success me-2"></i>Уникальные природные достопримечательности</li>
          <li class="mb-2"><i class="fa-solid fa-check-circle text-success me-2"></i>Гостеприимные местные жители</li>
          <li class="mb-3"><i class="fa-solid fa-check-circle text-success me-2"></i>Богатая история и культура</li>
        </ul>
        <a href="#contact" class="btn btn-dark">Связаться с нами</a>
      </div>
      <div class="col-md-6">
        <div class="row g-2">
          <div class="col-6"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow"></div>
          <div class="col-6"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow"></div>
          <div class="col-6"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow"></div>
          <div class="col-6"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== ПРЕИМУЩЕСТВА ========== -->
<section class="py-5 bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-5">Почему стоит выбрать Туркменистан?</h2>
    <div class="row g-4">
      <!-- Карточка 1 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <div class="text-danger mb-3"><i class="fa-solid fa-fire fa-3x"></i></div>
            <h5 class="card-title">Врата Ада</h5>
            <p class="card-text small">Уникальный газовый кратер Дарваза, горящий более 50-ти лет. Зрелище, которое невозможно забыть.</p>
          </div>
        </div>
      </div>
      <!-- Карточка 2 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <div class="text-danger mb-3"><i class="fa-solid fa-archway fa-3x"></i></div>
            <h5 class="card-title">Древние города</h5>
            <p class="card-text small">Руины Мерва, Куня-Ургенча и другие жемчужины Великого Шелкового пути, внесённые в список ЮНЕСКО.</p>
          </div>
        </div>
      </div>
      <!-- Карточка 3 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <div class="text-danger mb-3"><i class="fa-solid fa-horse fa-3x"></i></div>
            <h5 class="card-title">Ахалтекинские кони</h5>
            <p class="card-text small">Легендарные «небесные скакуны» — символ грации и выносливости.</p>
          </div>
        </div>
      </div>
      <!-- Карточка 4 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <div class="text-danger mb-3"><i class="fa-solid fa-umbrella-beach fa-3x"></i></div>
            <h5 class="card-title">Каспийское море</h5>
            <p class="card-text small">Современный курорт Аваза с песчаными пляжами и комфортными отелями.</p>
          </div>
        </div>
      </div>
      <!-- Карточка 5 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <div class="text-danger mb-3"><i class="fa-solid fa-utensils fa-3x"></i></div>
            <h5 class="card-title">Национальная кухня</h5>
            <p class="card-text small">Аутентичный плов, манты, шашлык — готовятся по старинным рецептам.</p>
          </div>
        </div>
      </div>
      <!-- Карточка 6 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <div class="text-danger mb-3"><i class="fa-solid fa-spa fa-3x"></i></div>
            <h5 class="card-title">Лечебные источники</h5>
            <p class="card-text small">Целебные воды и грязи, известные своими свойствами ещё с античности.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== ДАРВАЗА ========== -->
<section id="darwaza" class="py-5">
  <div class="container py-5">
    <h2 class="text-center mb-5">Дарваза — Врата Ада</h2>
    <div class="row gy-4 align-items-center">
      <div class="col-md-6 order-2 order-md-1">
        <p>Газовый кратер Дарваза, известный как «Врата Ада», — одно из самых загадочных мест планеты. Диаметром около 70 м и глубиной 20 м он горит непрерывно более 50 лет.</p>
        <p>По легенде кратер образовался в 1971 г., когда геологи случайно попали в подземную каверну с газом. Чтобы избежать выброса, газ подожгли… и он горит до сих пор.</p>
        <p>Ночью языки пламени поднимаются до 15 м, освещая пустыню зловещим светом. Это уникальное зрелище привлекает путешественников со всего мира.</p>
        <a href="#tours" class="btn btn-danger mt-3">Забронировать тур к Вратам Ада</a>
      </div>
      <div class="col-md-6 order-1 order-md-2">
        <div class="position-relative">
          <img src="https://images.unsplash.com/photo-1508514177221-188e1e464282?auto=format&fit=crop&w=1000&q=80" class="img-fluid rounded shadow" alt="Дарваза">
          <div class="position-absolute bottom-0 start-0 p-3 text-white">
            <h5 class="mb-0">«Это нужно увидеть своими глазами!»</h5>
            <small>— Марк, путешественник из Германии</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== ТУРЫ ========== -->
<section id="tours" class="py-5 bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-5">Наши популярные туры</h2>
    <div class="row g-4">
      <!-- Карточка 1 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow">
          <div class="position-relative">
            <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Тур к Вратам Ада">
            <span class="badge bg-danger position-absolute top-0 end-0 m-2">ХИТ</span>
          </div>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Тур к Вратам Ада</h5>
            <p class="card-text small">2 дня / 1 ночь. Незабываемое путешествие к газовому кратеру Дарваза с ночевкой в пустыне.</p>
            <div class="d-flex justify-content-between align-items-center mt-auto">
              <div><span class="text-decoration-line-through text-muted">$450</span><span class="fw-bold text-danger ms-2">$399</span></div>
              <div class="text-warning"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
            </div>
            <a href="#contact" class="btn btn-dark w-100 mt-2">Забронировать</a>
          </div>
        </div>
      </div>
      <!-- Карточка 2 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow">
          <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Древние города">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Древние города Туркменистана</h5>
            <p class="card-text small">5 дней / 4 ночи. Тур по историческим местам: Мерв, Куня-Ургенч, Ниса.</p>
            <div class="d-flex justify-content-between align-items-center mt-auto">
              <div><span class="fw-bold text-danger">$750</span></div>
              <div class="text-warning"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-alt"></i></div>
            </div>
            <a href="#contact" class="btn btn-dark w-100 mt-2">Забронировать</a>
          </div>
        </div>
      </div>
      <!-- Карточка 3 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow">
          <div class="position-relative">
            <img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Комбинированный тур">
            <span class="badge bg-success position-absolute top-0 end-0 m-2">НОВИНКА</span>
          </div>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Все сокровища Туркменистана</h5>
            <p class="card-text small">8 дней / 7 ночей. Комбинированный тур: Дарваза, Ашхабад, Мерв, Аваза.</p>
            <div class="d-flex justify-content-between align-items-center mt-auto">
              <div><span class="fw-bold text-danger">$1200</span></div>
              <div class="text-warning"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="far fa-star"></i></div>
            </div>
            <a href="#contact" class="btn btn-dark w-100 mt-2">Забронировать</a>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center mt-4"><a href="#contact" class="btn btn-danger btn-lg">Хочу индивидуальный тур</a></div>
  </div>
</section>

<!-- ========== ОТЗЫВЫ ========== -->
<section class="py-5">
  <div class="container py-5">
    <h2 class="text-center mb-5">Отзывы наших клиентов</h2>
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">АК</div>
              <div>
                <h6 class="mb-0 fw-bold">Анна К.</h6>
                <div class="text-warning small"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
              </div>
            </div>
            <p class="small fst-italic">«Врата Ада превзошли все ожидания! Ночью это выглядит нереально. Тур организован на высшем уровне. Вернусь снова!»</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">ИП</div>
              <div>
                <h6 class="mb-0 fw-bold">Иван П.</h6>
                <div class="text-warning small"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
              </div>
            </div>
            <p class="small fst-italic">«Контраст между современным Ашхабадом и древним Мервом запомнился навсегда. Спасибо за организацию!»</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">МС</div>
              <div>
                <h6 class="mb-0 fw-bold">Мария С.</h6>
                <div class="text-warning small"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-alt"></i></div>
              </div>
            </div>
            <p class="small fst-italic">«Отдых в Авазе был сказочным! А экскурсия к Вратам Ада добавила адреналина. Рекомендую!»</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== ГАЛЕРЕЯ ========== -->
<section class="py-5 bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-5">Туркменистан в фотографиях</h2>
    <div class="row g-3 gallery-item">
      <div class="col-6 col-md-3"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow" alt="pic1"></div>
      <div class="col-6 col-md-3"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow" alt="pic2"></div>
      <div class="col-6 col-md-3"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow" alt="pic3"></div>
      <div class="col-6 col-md-3"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow" alt="pic4"></div>
      <div class="col-6 col-md-3"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow" alt="pic5"></div>
      <div class="col-6 col-md-3"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow" alt="pic6"></div>
      <div class="col-6 col-md-3"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow" alt="pic7"></div>
      <div class="col-6 col-md-3"><img src="https://images.unsplash.com/photo-1580077871668-fdb475203b2a?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow" alt="pic8"></div>
    </div>
  </div>
</section>

<!-- ========== CTA-FORM ========== -->
<section class="py-5 text-white" style="background:url('https://images.unsplash.com/photo-1508514177221-188e1e464282?auto=format&fit=crop&w=2070&q=80') center/covered;">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-6 text-center">
        <h2 class="mb-4">Готовы к незабываемому приключению?</h2>
        <p class="mb-4">Оставьте заявку прямо сейчас, и мы подберём идеальный тур!</p>
        <div class="bg-white bg-opacity-10 p-4 rounded">
          <form id="cta-form">
            <div class="mb-3"><input type="text" class="form-control" placeholder="Ваше имя" required></div>
            <div class="mb-3"><input type="email" class="form-control" placeholder="Ваш email" required></div>
            <div class="mb-3"><input type="tel" class="form-control" placeholder="Ваш телефон" required></div>
            <div class="mb-3">
              <select class="form-select" required>
                <option value="">Выберите интересующий тур</option>
                <option>Тур к Вратам Ада</option>
                <option>Древние города Туркменистана</option>
                <option>Все сокровища Туркменистана</option>
                <option>Индивидуальный тур</option>
              </select>
            </div>
            <button class="btn btn-danger w-100">Отправить заявку</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== FAQ ========== -->
<section class="py-5">
  <div class="container py-5">
    <h2 class="text-center mb-5">Часто задаваемые вопросы</h2>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="accordion" id="faqAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq1">Нужна ли виза для посещения Туркменистана?</button></h2>
            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion"><div class="accordion-body">Для большинства иностранцев требуется виза. Мы поможем с приглашением и оформлением.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq2">Когда лучше всего посещать Дарваза?</button></h2>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">С марта по май и с сентября по ноябрь — комфортная температура. Летом +50°C, зимой ночью холодно.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq3">Безопасно ли посещение Врат Ада?</button></h2>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">Да, при соблюдении правил, которые объяснит гид. К кратеру не подходят близко.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq4">Что взять с собой в тур к Вратам Ада?</button></h2>
            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">Удобная обувь, тёплая одежда (ночью холодно), головной убор, SPF-крем, фотоаппарат, вода. Палатки и еду предоставим.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq5">Есть ли возрастные ограничения?</button></h2>
            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">Детям до 10 лет в Дарвазу не рекомендуем. Пожилым — оценить физические возможности.</div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== КОНТАКТЫ ========== -->
<section id="contact" class="py-5 bg-light">
  <div class="container py-5">
    <h2 class="text-center mb-5">Свяжитесь с нами</h2>
    <div class="row gy-4">
      <div class="col-lg-6">
        <form>
          <div class="mb-3"><input type="text" class="form-control" placeholder="Ваше имя" required></div>
          <div class="mb-3"><input type="email" class="form-control" placeholder="Ваш email" required></div>
          <div class="mb-3"><input type="tel" class="form-control" placeholder="Ваш телефон" required></div>
          <div class="mb-3"><textarea class="form-control" rows="5" placeholder="Ваше сообщение" required></textarea></div>
          <button class="btn btn-dark w-100">Отправить сообщение</button>
        </form>
      </div>
      <div class="col-lg-6">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Наши контакты</h5>
            <div class="d-flex align-items-start mb-3"><i class="fa-solid fa-map-marker-alt text-danger mt-1 me-3"></i><div><div class="fw-bold">Адрес:</div><span>г. Ашхабад, проспект Махтумкули, 123</span></div></div>
            <div class="d-flex align-items-start mb-3"><i class="fa-solid fa-phone-alt text-danger mt-1 me-3"></i><div><div class="fw-bold">Телефон:</div><span>+993 12 34 56 78</span></div></div>
            <div class="d-flex align-items-start mb-3"><i class="fa-solid fa-envelope text-danger mt-1 me-3"></i><div><div class="fw-bold">Email:</div><span>info@turkmentravel.com</span></div></div>
            <div class="d-flex align-items-start mb-3"><i class="fa-solid fa-clock text-danger mt-1 me-3"></i><div><div class="fw-bold">Часы работы:</div><span>Пн-Пт: 9:00–18:00<br>Сб: 10:00–15:00<br>Вс: выходной</span></div></div>
            <div>
              <div class="fw-bold mb-2">Мы в соцсетях:</div>
              <div class="d-flex gap-2">
                <a href="#" class="btn btn-sm btn-outline-dark"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="btn btn-sm btn-outline-dark"><i class="fab fa-twitter"></i></a>
                <a href="#" class="btn btn-sm btn-outline-dark"><i class="fab fa-instagram"></i></a>
                <a href="#" class="btn btn-sm btn-outline-dark"><i class="fab fa-youtube"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== FOOTER ========== -->
<footer class="bg-dark text-white py-4">
  <div class="container">
    <div class="row gy-3">
      <div class="col-md-4">
        <div class="d-flex align-items-center mb-2">
          <i class="fa-solid fa-fire text-danger me-2"></i><span class="fw-bold">TurkmenTravel</span>
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
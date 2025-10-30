<!-- ========== HERO-CAROUSEL ========== -->
<section id="home" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <!-- Индикаторы -->
  <div class="carousel-indicators">
    @foreach($carousels as $carousel)
    <button type="button" data-bs-target="#home" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></button>
    @endforeach
  </div>

  <!-- Слайды -->
  <div class="carousel-inner">
    <!-- Слайд 1 -->
     @foreach($carousels as $carousel)
    <div class="carousel-item {{ $loop->first ? 'active' : '' }}"
         data-bs-interval="3000"
         style="background-image:url({{ asset('uploads/' . $carousel->image) }});">
      <div class="carousel-caption  text-center">
        <h1 class="display-3 fw-bold">{{ $carousel->title }}</h1>
        <p class="lead mb-4">{{ $carousel->description }}</p>
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
          <a href="#tours" class="btn btn-danger btn-lg">{{ $carousel->button_text }}</a>
          <a href="#darwaza" class="btn btn-outline-light btn-lg">All Tours</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Стрелки -->
    <button class="carousel-control-prev" type="button"
            data-bs-target="#home" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button"
            data-bs-target="#home" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
    </button>
</section>

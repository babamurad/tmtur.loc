<div class="container">
    <div class="row mt-2">
        <!-- Main news -->
        <div class="col-xl-8 col-md-12">
            <!-- Post -->
            <div class="row mt-2 mb-5 pb-3 mx-2">
                <!-- Card -->
                <div class="card card-body mb-5">
                    <div class="post-data mb-4">
                        <p class="font-small text-secondary mb-1">
                            <strong>Автор:</strong> {{ $post->user->name ?? 'Неизвестно' }}</p>
                        <p class="font-small text-secondary">
                            <i class="far fa-clock"></i> {{ $post->published_at->format('d/m/Y в H:i') }}</p>
                    </div>
                    <!-- Title -->
                    <h2 class="fw-bold mt-3">
                        <strong>{{ $post->title }}</strong>
                    </h2>
                    <hr class="border-danger border-2 opacity-75">
                    @if ($post->image)
                        <img src="{{ asset('uploads/' . $post->image) }}" class="img-fluid rounded shadow-1-strong"
                            alt="{{ $post->title }}">
                    @endif
                    <!-- Grid row -->
                    <div class="row">
                        <!-- Grid column -->
                        <div class="col-md-6 mt-4">
                            <h5 class="fw-bold text-dark">
                                <i class="far fa-eye me-3 text-dark"></i>
                                <strong>{{ $post->views ?? 0 }}</strong> Просмотров</h5>
                        </div>
                        <!-- Grid column -->
                        <!-- Grid column -->
                        <div class="col-md-6 mt-2 d-flex justify-content-end">
                            <!-- Facebook -->
                            <a type="button" class="btn btn-primary btn-sm me-2">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <!-- Twitter -->
                            <a type="button" class="btn btn-info btn-sm me-2">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <!-- Google + -->
                            <a type="button" class="btn btn-danger btn-sm">
                                <i class="fab fa-google-plus-g"></i>
                            </a>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                    <hr>
                    <!-- Grid row -->
                    <div class="row mx-md-4 px-4 mt-3">
                        <p class="text-dark article">{{ $post->content }}</p>
                    </div>
                    <!-- Grid row -->
                    <hr>
                    <!-- Grid row -->
                    <div class="row mb-4">
                        <!-- Grid column -->
                        <div class="col-md-12 text-center">
                            <h4 class="text-center fw-bold text-dark mt-3 mb-3">
                                <strong>Поделиться этим постом: </strong>
                            </h4>
                            <button type="button" class="btn btn-primary btn-sm me-2">
                                <i class="fab fa-facebook-f me-1"></i> Facebook</button>
                            <!-- Twitter -->
                            <button type="button" class="btn btn-info btn-sm me-2">
                                <i class="fab fa-twitter me-1"></i> Twitter</button>
                            <!-- Google + -->
                            <button type="button" class="btn btn-danger btn-sm">
                                <i class="fab fa-google-plus-g me-1"></i> Google +</button>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                </div>
                <!-- Card -->
                <section class="text-start">
                    <!-- Author box -->
                    <div class="card card-body">
                        <div class="row">
                            <!-- Avatar -->
                            <div class="col-12 col-sm-2 mb-md-0 mb-3">
                                <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(26).jpg"
                                    class="img-fluid rounded-circle" alt="">
                            </div>
                            <!-- Author Data -->
                            <div class="col-12 col-sm-10">
                                <p>
                                    <strong>{{ $post->user->name ?? 'Неизвестно' }}</strong>
                                </p>
                                <div class="personal-sm">
                                    <a class="me-2 text-primary">
                                        <i class="fab fa-facebook-f"> </i>
                                    </a>
                                    <a class="me-2 text-info">
                                        <i class="fab fa-twitter"> </i>
                                    </a>
                                    <a class="me-2 text-danger">
                                        <i class="fab fa-google-plus-g"> </i>
                                    </a>
                                    <a class="me-2 text-primary">
                                        <i class="fab fa-linkedin-in"> </i>
                                    </a>
                                </div>
                                <p class="text-dark article">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Author box -->
                </section>
            </div>
            <!-- Post -->
        </div>
        <!-- Main news -->
        <!-- Sidebar -->
        <div class="col-xl-4 col-md-12 widget-column mt-0">
            <!-- Section: Categories -->
            <section class="section mb-5">
                <h4 class="fw-bold mt-2">
                    <strong>КАТЕГОРИИ</strong>
                </h4>
                <hr class="border-danger border-2 opacity-75">
                <ul class="list-group shadow-1-strong mt-4">
                    @foreach ($categories as $category)
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <a href="{{ route('blog.category', $category->slug) }}" class="text-decoration-none text-dark">{{ $category->title }}</a>
                            <span class="badge bg-danger rounded-pill">{{ $category->posts_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
            <!-- Section: Categories -->
            <!-- Section: Featured posts -->
            <section class="section widget-content">
                <!-- Heading -->
                <h4 class="fw-bold pt-2">
                    <strong>ПОПУЛЯРНЫЕ ПОСТЫ</strong>
                </h4>
                <hr class="border-danger border-2 opacity-75 mb-4">
                <!-- Card -->
                <div class="card card-body pb-0">
                    @foreach (\App\Models\Post::where('status', true)->orderBy('views', 'desc')->take(5)->get() as $featuredPost)
                        <div class="single-post mb-3">
                            <!-- Grid row -->
                            <div class="row">
                                <div class="col-4">
                                    <!-- Image -->
                                    <div class="bg-image hover-overlay ripple rounded shadow-1-strong" data-ripple-color="light">
                                        @if ($featuredPost->image)
                                        <a href="{{ route('blog.show', $featuredPost->slug) }}">
                                            <div class="mask" style="background-color: rgba(255, 255, 255, 0.15);">
                                                <img src="{{ asset('uploads/' . $featuredPost->image) }}"
                                                class="img-fluid" alt="{{ $featuredPost->title }}">
                                            </div>
                                        </a>                                            
                                        @endif
                                        
                                    </div>
                                </div>
                                <!-- Excerpt -->
                                <div class="col-8">
                                    <h6 class="mt-0 mb-3">
                                        <a href="{{ route('blog.show', $featuredPost->slug) }}">
                                            <strong>{{ Str::limit($featuredPost->title, 50) }}</strong>
                                        </a>
                                    </h6>
                                    <div class="post-data">
                                        <p class="font-small text-secondary mb-0">
                                            <i class="far fa-clock"></i> {{ $featuredPost->published_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <!-- Excerpt -->
                            </div>
                            <!-- Grid row -->
                        </div>
                    @endforeach
                </div>
            </section>
            <!-- Section: Featured posts -->
        </div>
        <!-- Sidebar -->
    </div>
    <!-- Magazine -->
</div>
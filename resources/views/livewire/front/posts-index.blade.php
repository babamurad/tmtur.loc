<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-8">
            <!-- Посты будут здесь -->
            <h1>{{ __('messages.posts_list') }}</h1>
            @foreach ($posts as $post)
                <div class="card mb-4">
                    @if ($post->image)
                        <img src="{{ asset('uploads/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{ $post->tr('title') }}</h2>
                        <!-- <p class="card-text">{!! Str::limit($post->tr('content'), 150) !!}</p> -->
                         <div>{{ $post->tr('content') }}</div>
                        
                        <a href="{{ route('blog.show', $post->slug) }}"
                            class="btn btn-primary read-more-btn">{{ __('messages.read_more') }}</a>
                    </div>
                    <div class="card-footer text-muted">
                        {{ __('messages.published') }} {{ $post->created_at->diffForHumans() }}
                        {{ __('messages.in_category') }} <a
                            href="{{ route('blog.category', $post->category->slug) }}">{{ $post->category->tr('title') }}</a>
                        <span class="float-end"><i class="far fa-eye"></i> {{ $post->views }}</span>
                        
                    </div>
                </div>
            @endforeach

            {{ $posts->links() }}
        </div>
        <div class="col-md-4">
            <!-- Сайдбар с категориями -->
            <section class="section mb-5">
                <h4 class="fw-bold mt-2">
                    <strong>{{ __('messages.categories') }}</strong>
                </h4>
                <hr class="border-danger border-2 opacity-75">
                <ul class="list-group shadow-1-strong mt-4">
                    @foreach ($categories as $category)
                        <li
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <a href="{{ route('blog.category', $category->slug) }}"
                                class="text-decoration-none text-dark">{{ $category->tr('title') }}</a>
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
                    <strong>{{ __('messages.popular_posts') }}</strong>
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
                                    <div class="bg-image hover-overlay ripple rounded shadow-1-strong"
                                        data-ripple-color="light">
                                        @if ($featuredPost->image)
                                            <a href="{{ route('blog.show', $featuredPost->slug) }}">
                                                <div class="mask" style="background-color: rgba(255, 255, 255, 0.15);">
                                                    <img src="{{ asset('uploads/' . $featuredPost->image) }}" class="img-fluid"
                                                        alt="{{ $featuredPost->tr('title') }}">
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <!-- Excerpt -->
                                <div class="col-8">
                                    <h6 class="mt-0 mb-3">
                                        <a href="{{ route('blog.show', $featuredPost->slug) }}">
                                            <strong>{{ Str::limit($featuredPost->tr('title'), 50) }}</strong>
                                        </a>
                                    </h6>
                                    <div class="post-data">
                                        <p class="font-small text-secondary mb-0">
                                            <i class="far fa-clock"></i> {{ $featuredPost->published_at->diffForHumans() }}
                                        </p>
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
    </div>
</div>
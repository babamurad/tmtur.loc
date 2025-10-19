<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- Посты будут здесь -->
            <h1>Список постов</h1>
            @foreach ($posts as $post)
                <div class="card mb-4">
                    @if ($post->image)
                        <img src="{{ asset('uploads/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{ $post->title }}</h2>
                        <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                        <a href="{{ route('blog.show', $post->id) }}" class="btn btn-primary">Читать далее</a>
                    </div>
                    <div class="card-footer text-muted">
                        Опубликовано {{ $post->created_at->diffForHumans() }} в категории <a href="{{ route('blog.category', $post->category->slug) }}">{{ $post->category->name }}</a>
                    </div>
                </div>
            @endforeach

            {{ $posts->links() }}
        </div>
        <div class="col-md-4">
            <!-- Сайдбар с категориями -->
            <div class="card my-4">
                <h5 class="card-header">Категории</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled mb-0">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('blog.category', $category->slug) }}">{{ $category->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

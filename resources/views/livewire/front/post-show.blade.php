<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- Пост -->
            <div class="card mb-4">
                @if ($post->image)
                    <img src="{{ asset('uploads/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                @endif
                <div class="card-body">
                    <h1 class="card-title">{{ $post->title }}</h1>
                    <p class="card-text">{{ $post->content }}</p>
                </div>
                <div class="card-footer text-muted">
                    Опубликовано {{ $post->created_at->diffForHumans() }} в категории <a href="{{ route('blog.category', $post->category->slug) }}">{{ $post->category->name }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Сайдбар с категориями -->
            <div class="card my-4">
                <h5 class="card-header">Категории</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled mb-0">
                                @foreach (\App\Models\Category::where('is_published', true)->get() as $category)
                                    <li>
                                        <a href="{{ route('blog.category', $category->slug) }}">{{ $category->name }}</a>
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
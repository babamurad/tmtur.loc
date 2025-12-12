<div class="container">
    <div class="row mt-2">

        {{-- ===== JS: копирование ссылки ===== --}}
        <script>
            function copyPostLink(evt) {
                const url = window.location.href;
                showCopySuccess(evt.currentTarget);          // визуальный отклик
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(url).catch(() => fallbackCopyText(url));
                } else { fallbackCopyText(url); }
            }
            function fallbackCopyText(text) {
                const ta = document.createElement('textarea');
                ta.value = text; ta.style.position = 'fixed'; ta.style.left = '-9999px';
                document.body.appendChild(ta); ta.focus(); ta.select();
                try { document.execCommand('copy'); } catch (e) {
                    console.warn(e);
                    alert('Не удалось скопировать. Скопируйте вручную:\n' + text);
                }
                document.body.removeChild(ta);
            }

            function showCopySuccess(btn) {
                /* 1. находим иконку внутри кнопки */
                const icon = btn.querySelector('i');          // <i class="fas fa-link …">
                if (!icon) return;

                /* 2. сохраняем исходные классы иконки */
                const origClasses = icon.className;           // "fas fa-link me-1"
                const origColor = btn.className.match(/text-\w+/); // цвет кнопки

                /* 3. ставим галочку и зелёный цвет */
                icon.className = 'fas fa-check';
                btn.classList.remove('text-primary', 'text-info', 'text-success', 'text-dark', 'text-secondary');
                btn.classList.add('text-success');

                /* 4. через 2 с возвращаем всё обратно */
                setTimeout(() => {
                    icon.className = origClasses;
                    btn.classList.remove('text-success');
                    if (origColor) btn.classList.add(origColor[0]);
                }, 2000);
            }
        </script>

        <!--  ============  ЛЕВАЯ КОЛОНКА: сам пост  ============  -->
        <div class="col-xl-8 col-md-12">
            <div class="row mt-2 mb-5 pb-3 mx-2">

                {{-- Карточка поста --}}
                <div class="card card-body mb-5">
                    <div class="post-data mb-4">
                        <p class="font-small text-secondary mb-1">
                            <strong>{{ __('messages.author') }}</strong>
                            {{ $post->user->name ?? __('messages.unknown') }}
                        </p>
                        <p class="font-small text-secondary">
                            <i class="far fa-clock"></i> {{ $post->published_at->format('d/m/Y в H:i') }}
                        </p>
                    </div>

                    <h2 class="fw-bold mt-3"><strong>{{ $post->tr('title') }}</strong></h2>
                    <hr class="border-danger border-2 opacity-75">

                    @if($post->image)
                        <img src="{{ asset('uploads/' . $post->image) }}" class="img-fluid rounded shadow-1-strong"
                            alt="{{ $post->tr('title') }}">
                    @endif

                    {{-- счётчик + маленькие кнопки под заголовком --}}
                    <div class="row">
                        <div class="col-md-6 mt-4">
                            <h5 class="fw-bold text-dark">
                                <i class="far fa-eye me-3 text-dark"></i>
                                <strong>{{ $post->views ?? 0 }}</strong> {{ __('messages.views') }}
                            </h5>
                        </div>
                        <div class="col-md-6 mt-2 d-flex justify-content-end">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank" class="btn btn-primary btn-sm "><i
                                    class="fab fa-facebook-f fa-2x"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->tr('title')) }}"
                                target="_blank" class="btn btn-dark btn-sm "><i class="fab fa-x-twitter fa-2x"></i></a>
                            <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->tr('title')) }}"
                                target="_blank" class="btn btn-info btn-sm "><i class="fab fa-telegram fa-2x"></i></a>
                            <a href="https://wa.me/?text={{ urlencode($post->tr('title') . ' - ' . request()->url()) }}"
                                target="_blank" class="btn btn-success btn-sm"><i class="fab fa-whatsapp fa-2x"></i></a>
                        </div>
                    </div>

                    <hr>

                    {{-- текст поста --}}
                    <div class="row mx-md-4 px-4 mt-3">
                        <div class="col-12">
                            <div class="text-dark article">{!! $post->tr('content') !!}</div>
                        </div>
                    </div>

                    <hr>

                    {{-- Большие кнопки «Поделиться» --}}
                    <div class="row mb-4">
                        <div class="col-md-12 text-center share-buttons">
                            <h4 class="fw-bold text-dark mt-3 mb-3"><strong>{{ __('messages.share_post') }}</strong>
                            </h4>

                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank" class="btn btn-primary btn-sm "><i class="fab fa-facebook-f mr-1"></i>
                                Facebook</a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->tr('title')) }}"
                                target="_blank" class="btn btn-dark btn-sm "><i class="fab fa-x-twitter mr-1"></i></a>
                            <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->tr('title')) }}"
                                target="_blank" class="btn btn-info btn-sm "><i class="fab fa-telegram mr-1"></i>
                                Telegram</a>
                            <a href="https://wa.me/?text={{ urlencode($post->tr('title') . ' - ' . request()->url()) }}"
                                target="_blank" class="btn btn-success btn-sm "><i class="fab fa-whatsapp mr-1"></i>
                                WhatsApp</a>
                            <button onclick="copyPostLink(event)" class="btn btn-secondary btn-sm" title="Copy link"><i
                                    class="fas fa-link mr-1"></i> Copy Link</button>
                        </div>
                    </div>
                </div>
                {{-- /карточка поста --}}

                {{-- ОБЛАСТЬ АВТОРА --}}
                <section class="text-start">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-12 col-sm-2 mb-md-0 mb-3">
                                <img src="{{ $post->user?->avatar_url ?? asset('img/placeholder_avatar.png') }}"
                                    class="img-fluid rounded-circle" alt="{{ $post->user->name ?? 'Admin' }}">
                            </div>
                            <div class="col-12 col-sm-10">
                                <p><strong><span>{{ __('messages.author') }}</span>
                                        {{ $post->user->name ?? __('messages.unknown') }}</strong></p>
                                <div class="personal-sm">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                        target="_blank" class=" text-primary"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->tr('title')) }}"
                                        target="_blank" class=" text-dark"><i class="fab fa-x-twitter"></i></a>
                                    <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->tr('title')) }}"
                                        target="_blank" class=" text-info"><i class="fab fa-telegram"></i></a>
                                    <a href="https://wa.me/?text={{ urlencode($post->tr('title') . ' - ' . request()->url()) }}"
                                        target="_blank" class=" text-success"><i class="fab fa-whatsapp"></i></a>
                                    <a href="#" onclick="copyPostLink(event);return false;" class=" text-secondary"
                                        title="Copy link"><i class="fas fa-link"></i></a>
                                </div>
                                <!-- <p class="text-dark article">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p> -->
                            </div>
                        </div>
                    </div>
                </section>

            </div>{{-- /row поста --}}
        </div>{{-- /левая колонка --}}


        <!--  ============  ПРАВАЯ КОЛОНКА: сайдбар  ============  -->
        <div class="col-xl-4 col-md-12 widget-column mt-0">

            {{-- Категории --}}
            <section class="section mb-5">
                <h4 class="fw-bold mt-2"><strong>{{ __('messages.categories') }}</strong></h4>
                <hr class="border-danger border-2 opacity-75">
                <ul class="list-group shadow-1-strong mt-4">
                    @foreach($categories as $cat)
                        <li
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <a href="{{ route('blog.category', $cat->slug) }}"
                                class="text-decoration-none text-dark">{{ $cat->tr('title') }}</a>
                            <span class="badge bg-danger rounded-pill">{{ $cat->posts_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>

            {{-- Популярные посты --}}
            <section class="section widget-content">
                <h4 class="fw-bold pt-2"><strong>{{ __('messages.popular_posts') }}</strong></h4>
                <hr class="border-danger border-2 opacity-75 mb-4">
                <div class="card card-body pb-0">
                    @foreach(\App\Models\Post::where('status', true)->orderBy('views', 'desc')->take(5)->get() as $fp)
                        <div class="single-post mb-3">
                            <div class="row">
                                <div class="col-4">
                                    <div class="bg-image hover-overlay ripple rounded shadow-1-strong"
                                        data-ripple-color="light">
                                        @if($fp->image)
                                            <a href="{{ route('blog.show', $fp->slug) }}">
                                                <div class="mask" style="background-color:rgba(255,255,255,0.15)">
                                                    <img src="{{ asset('uploads/' . $fp->image) }}" class="img-fluid"
                                                        alt="{{ $fp->tr('title') }}">
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-8">
                                    <h6 class="mt-0 mb-3">
                                        <a
                                            href="{{ route('blog.show', $fp->slug) }}"><strong>{{ \Illuminate\Support\Str::limit($fp->tr('title'), 50) }}</strong></a>
                                    </h6>
                                    <div class="post-data">
                                        <p class="font-small text-secondary mb-0"><i class="far fa-clock"></i>
                                            {{ $fp->published_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>{{-- /правая колонка --}}
    </div>{{-- /row основной --}}
</div>{{-- /container --}}
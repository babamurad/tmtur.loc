<div class="simple-gallery mt-5 pt-3">
    <div class="container">
        <h1 class="text-center mb-4">{{ __('menu.gallery') ?? 'Gallery' }}</h1>
    </div>
    @push('quill-css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    @endpush

    <div class="container" x-data="{ lightbox: null }" x-init="
        lightbox = GLightbox({
            selector: '.glightbox-item',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true
        });
        
        // Update lightbox when active index changes if needed, 
        // but GLightbox handles its own state. 
        // We just need to ensure the list is static or re-inited if list changes.
        // Since list is static here, one init is enough.
    ">
        <!-- Hidden gallery items for GLightbox -->
        <div class="d-none">
            @foreach($images as $imgIndex => $img)
                <a href="{{ 'uploads/' . $img->file_path }}" class="glightbox-item"
                    data-gallery="gallery-{{ $this->getId() }}" data-title="{{ $img->tr('title') }}"
                    data-description="{{ $img->tr('description') }}">
                </a>
            @endforeach
        </div>

        <!-- Главное изображение -->
        <div class="main-image mb-4 text-center">
            <img src="{{ 'uploads/' . ($images[$activeIndex]->file_path ?? '') }}"
                style="max-height: 60vh; width: auto; cursor: pointer;" class="img-fluid rounded shadow-lg"
                alt="{{ $images[$activeIndex]->tr('alt_text') ?? 'Gallery image' }}"
                @click="lightbox.openAt({{ $activeIndex }})">
        </div>

        <!-- Информация о фото - компактная версия -->
        @if($images[$activeIndex]->tr('title') || $images[$activeIndex]->tr('location') || $images[$activeIndex]->tr('photographer') || $images[$activeIndex]->tr('description'))
            <div class="photo-info bg-light p-3 rounded mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        @if($images[$activeIndex]->tr('title'))
                            <h5 class="mb-2 font-weight-bold">{{ $images[$activeIndex]->tr('title') }}</h5>
                        @endif

                        @if($images[$activeIndex]->tr('description'))
                            <p class="text-muted mb-2 small">
                                {!! Str::limit(strip_tags($images[$activeIndex]->tr('description')), 150) !!}</p>
                        @endif
                    </div>

                    <div class="col-md-4 text-md-right">
                        @if($images[$activeIndex]->tr('location'))
                            <div class="mb-1">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                <small class="text-muted">{{ $images[$activeIndex]->tr('location') }}</small>
                            </div>
                        @endif

                        @if($images[$activeIndex]->tr('photographer'))
                            <div>
                                <i class="fas fa-camera text-primary"></i>
                                <small class="text-muted">{{ $images[$activeIndex]->tr('photographer') }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Миниатюры (улучшенная карусель) -->
        <div class="w-100" x-data x-init="
            const lane = $refs.lane;

            // Прокрутка колесом мыши
            lane.addEventListener('wheel', (e) => {
                e.preventDefault();
                lane.scrollLeft += e.deltaY;
            });

            // Drag (перетаскивание)
            let isDown = false;
            let startX;
            let scrollLeft;

            lane.addEventListener('mousedown', (e) => {
                isDown = true;
                lane.classList.add('dragging');
                startX = e.pageX - lane.offsetLeft;
                scrollLeft = lane.scrollLeft;
            });

            lane.addEventListener('mouseleave', () => isDown = false);
            lane.addEventListener('mouseup', () => isDown = false);

            lane.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - lane.offsetLeft;
                const walk = (x - startX) * 2;
                lane.scrollLeft = scrollLeft - walk;
            });
        ">
            <div class="d-flex align-items-center justify-content-center my-3" x-data>

                <!-- стрелка влево -->
                <button class="thumb-nav-btn btn btn-light rounded-circle shadow-sm"
                    @click="$refs.lane.scrollLeft -= ($refs.lane.firstElementChild.offsetWidth + 4)">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <!-- миниатюры -->
                <div class="position-relative mx-3" style="max-width:600px; overflow:hidden;">
                    <div class="d-flex" x-ref="lane"
                        style="overflow-x:auto; scroll-behavior:smooth; white-space:nowrap;">
                        @foreach ($images as $index => $image)
                            <div class="flex-shrink-0 px-1" style="width:20%;">
                                <button wire:click="setActive({{ $index }})" class="border-0 p-0 bg-transparent w-100"
                                    title="{{ $image->tr('title') }}">
                                    <img src="{{ 'uploads/' . $image->file_path }}"
                                        class="img-fluid rounded shadow-sm {{ $activeIndex === $index ? 'border border-primary border-3' : '' }}"
                                        style="height:100px;object-fit:cover;width:100%; transition: all 0.3s;"
                                        alt="{{ $image->tr('alt_text') }}">
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- стрелка вправо -->
                <button class="thumb-nav-btn btn btn-light rounded-circle shadow-sm"
                    @click="$refs.lane.scrollLeft += ($refs.lane.firstElementChild.offsetWidth + 4)">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

            </div>
        </div>
    </div>

    <style>
        [x-ref="lane"]::-webkit-scrollbar {
            display: none;
        }

        .dragging {
            cursor: grabbing !important;
        }

        .thumb-nav-btn {
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumb-nav-btn:hover {
            background-color: #f8f9fa;
        }
    </style>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    @endpush
</div>
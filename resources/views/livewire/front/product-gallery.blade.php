<div class="simple-gallery mt-5 pt-3">
    <div class="container">
        <h1 class="text-center mb-4">{{ __('menu.gallery') ?? 'Gallery' }}</h1>
    </div>

    {{-- GLightbox removed --}}

    <div class="container">

        <!-- Главное изображение -->
        <div class="main-image mb-4 text-center">
            <img src="{{ 'uploads/' . ($images[$activeIndex]->file_path ?? '') }}"
                style="max-height: 60vh; width: auto; cursor: pointer;" class="img-fluid rounded shadow-lg"
                alt="{{ $images[$activeIndex]->tr('alt_text') ?? 'Gallery image' }}"
                onclick="showGalleryImage({{ $activeIndex }})" data-toggle="modal" data-target="#galleryModal">
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
                                {!! Str::limit(strip_tags($images[$activeIndex]->tr('description')), 150) !!}
                            </p>
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

    {{-- FULLSCREEN MODAL --}}
    @if($images && count($images) > 0)

        <style>
            /* Custom Fullscreen Modal for Bootstrap 4 */
            .modal-fullscreen {
                padding: 0 !important;
            }

            .modal-fullscreen .modal-dialog {
                width: 100%;
                max-width: none;
                height: 100%;
                margin: 0;
            }

            .modal-fullscreen .modal-content {
                height: 100%;
                border: 0;
                border-radius: 0;
            }

            .modal-fullscreen .modal-body {
                overflow: hidden;
                background-color: #000;
            }
        </style>

        <!-- Modal -->
        <div class="modal fade modal-fullscreen" id="galleryModal" tabindex="-1" role="dialog"
            aria-labelledby="galleryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-dark">
                    <div class="modal-header border-0 bg-dark p-3">
                        <h5 class="modal-title text-white" id="galleryModalLabel">
                            <i class="fas fa-images mr-2"></i> {{ __('menu.gallery') ?? 'Gallery' }}
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0 d-flex align-items-center justify-content-center">
                        <div id="galleryCarousel" class="carousel slide w-100 h-100" data-ride="carousel"
                            data-interval="false">
                            {{-- Indicators --}}
                            <ol class="carousel-indicators">
                                @foreach($images as $index => $img)
                                    <li data-target="#galleryCarousel" data-slide-to="{{ $index }}"
                                        class="{{ $index === 0 ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>

                            {{-- Slides --}}
                            <div class="carousel-inner h-100">
                                @foreach($images as $index => $img)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }} h-100">
                                        <div class="d-flex justify-content-center align-items-center h-100">
                                            <img src="{{ 'uploads/' . $img->file_path }}" class="d-block img-fluid"
                                                alt="{{ $img->tr('alt_text') }}"
                                                style="max-height: 100vh; max-width: 100%; object-fit: contain;">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Controls --}}
                            @if(count($images) > 1)
                                <a class="carousel-control-prev" href="#galleryCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#galleryCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-dark justify-content-center py-2">
                        <span class="text-white small">
                            <i class="fas fa-image"></i>
                            <span id="currentImageNumber">1</span> / {{ count($images) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                function showGalleryImage(index) {
                    $('#galleryCarousel').carousel(index);
                }

                $(document).ready(function () {
                    // Update image counter
                    $('#galleryCarousel').on('slid.bs.carousel', function (e) {
                        var currentIndex = $(e.relatedTarget).index() + 1;
                        $('#currentImageNumber').text(currentIndex);
                    });

                    // Keyboard navigation
                    $('#galleryModal').on('shown.bs.modal', function () {
                        $(document).on('keydown.gallery', function (e) {
                            if (e.keyCode == 37) { // Left arrow
                                $('#galleryCarousel').carousel('prev');
                            } else if (e.keyCode == 39) { // Right arrow
                                $('#galleryCarousel').carousel('next');
                            }
                        });
                    });

                    $('#galleryModal').on('hidden.bs.modal', function () {
                        $(document).off('keydown.gallery');
                    });
                });
            </script>
        @endpush
    @endif

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
</div>
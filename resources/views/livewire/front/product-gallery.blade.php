<div class="simple-gallery mt-5 pt-3">
    <div class="container">
        <h1 class="text-center mb-4">{{ __('menu.gallery') ?? 'Gallery' }}</h1>
    </div>

    {{-- GLightbox removed --}}

    <style>
        .gallery-masonry {
            column-count: 3;
            column-gap: 1.5rem;
        }
        @media (max-width: 992px) {
            .gallery-masonry {
                column-count: 2;
            }
        }
        @media (max-width: 576px) {
            .gallery-masonry {
                column-count: 1;
            }
        }
        .gallery-item {
            display: inline-block;
            width: 100%;
            margin-bottom: 1.5rem;
            break-inside: avoid;
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .gallery-item:hover {
            transform: translateY(-5px);
        }
        .gallery-item img {
            width: 100%;
            border-radius: 0.5rem;
        }
        .card-img-overlay-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            color: #fff;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .gallery-item:hover .card-img-overlay-bottom {
            opacity: 1;
        }
    </style>

    <div class="container mobile-padding"> 
        <div class="gallery-masonry">
            @foreach ($images as $index => $image)
                <div class="gallery-item card border-0 shadow-sm" onclick="showGalleryImage({{ $index }})" data-toggle="modal" data-target="#galleryModal">
                    <div class="position-relative">
                        <img src="{{ 'uploads/' . $image->file_path }}" 
                             class="card-img-top" 
                             alt="{{ $image->tr('alt_text') ?? $image->tr('title') }}">
                        
                        @if($image->tr('title') || $image->tr('location'))
                            <div class="card-img-overlay-bottom">
                                @if($image->tr('title'))
                                    <h6 class="mb-0 font-weight-bold">{{ $image->tr('title') }}</h6>
                                @endif
                                @if($image->tr('location'))
                                    <small class="d-block"><i class="fas fa-map-marker-alt text-danger mr-1"></i>{{ $image->tr('location') }}</small>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
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
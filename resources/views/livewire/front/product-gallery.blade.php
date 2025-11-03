<div class="simple-gallery mt-5 pt-3">
    <!-- Главное изображение -->
    <div class="main-image mb-3 text-center">
        <img src="{{ 'uploads/' . ($images[$activeIndex]->file_path ?? '') }}"
             style="height: 40rem;"
             class="img-fluid rounded" alt="Gallery image">
    </div>

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
            const walk = (x - startX) * 2; // скорость
            lane.scrollLeft = scrollLeft - walk;
        });
    ">
        <div class="d-flex align-items-center justify-content-center my-3" x-data>

            <!-- стрелка влево -->
            <button class="thumb-nav-btn"
                    @click="$refs.lane.scrollLeft -= ($refs.lane.firstElementChild.offsetWidth + 4)">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <!-- миниатюры -->
            <div class="position-relative mx-2" style="max-width:520px; overflow:hidden;">
                <div class="d-flex"
                     x-ref="lane"
                     style="overflow-x:auto; scroll-behavior:smooth; white-space:nowrap;">
                    @foreach ($images as $index => $image)
                        <div class="flex-shrink-0 px-1" style="width:25%;">
                            <button wire:click="setActive({{ $index }})"
                                    class="border-0 p-0 bg-transparent w-100">
                                <img src="{{ 'uploads/' . $image->file_path }}"
                                     class=" img-fluid rounded shadow {{ $activeIndex === $index ? 'border-primary border-2' : '' }}"
                                     style="height:110px;object-fit:cover;width:100%;">
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- стрелка вправо -->
            <button class="thumb-nav-btn"
                    @click="$refs.lane.scrollLeft += ($refs.lane.firstElementChild.offsetWidth + 4)">
                <i class="fa-solid fa-chevron-right"></i>
            </button>

        </div>


    </div>
    <style>
        [x-ref="lane"]::-webkit-scrollbar {
            display: none;
        }
        .dragging {
            cursor: grabbing !important;
        }
    </style>
</div>

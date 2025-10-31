<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Create Tour</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tours</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Основная информация -->
            <div class="col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Tour details</h5>

                        <form wire:submit.prevent="save">
                            <div class="row">
                                <!-- Title -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text"
                                               id="title"
                                               wire:model.debounce.300ms="title"
                                               wire:input="generateSlug"
                                               class="form-control @error('title') is-invalid @enderror"
                                               placeholder="e.g. City Tour">
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <small class="form-text text-muted">Slug: {{ $slug }}</small>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_id">Category <span class="text-danger">*</span></label>
                                        <select wire:model.defer="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">-- Choose category --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Base Price -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="base_price_cents">Price (in cents) <span class="text-danger">*</span> </label>
                                        <input type="number"
                                               wire:model.defer="base_price_cents"
                                               class="form-control @error('base_price_cents') is-invalid @enderror"
                                               placeholder="e.g. 150000 (for 1500.00)">
                                        @error('base_price_cents')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Duration Days -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="duration_days">Duration (days) <span class="text-danger">*</span> </label>
                                        <input type="number"
                                               wire:model.defer="duration_days"
                                               class="form-control @error('duration_days') is-invalid @enderror"
                                               placeholder="e.g. 5">
                                        @error('duration_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Short Description -->
                                <div class="col-md-12">
                                    <div wire:ignore class="form-group">
                                        <label for="summernote-content">Short Description</label>
                                        <textarea id="summernote-content"
                                                  name="summernote-content"
                                                  class="form-control @error('short_description') is-invalid @enderror"
                                                  placeholder="e.g. Brief description of the tour"
                                                  x-ref="editor"
                                                  rows="3"
                                        >{{ old('short_description', $short_description) }}</textarea> <!-- Добавлено old для сохранения данных при ошибках валидации -->
                                        @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Itinerary Days -->
                            <h5 class="card-title mb-4 mt-4">Tour Itinerary</h5>
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-outline-success mb-2" wire:click="addItineraryDay">+ Add Day</button>
                                @foreach($itinerary_days as $index => $day)
                                    <div class="card mb-2">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <span>Day {{ $index + 1 }}</span>
                                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeItineraryDay({{ $index }})">Remove</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <input type="number" wire:model.defer="itinerary_days.{{ $index }}.day_number" class="form-control" placeholder="Day #" min="1">
                                                    @error("itinerary_days.{$index}.day_number") <div class="text-danger">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="text" wire:model.defer="itinerary_days.{{ $index }}.title" class="form-control" placeholder="Day Title">
                                                    @error("itinerary_days.{$index}.title") <div class="text-danger">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <textarea wire:model.defer="itinerary_days.{{ $index }}.description" class="form-control" placeholder="Day Description" rows="3"></textarea>
                                                    @error("itinerary_days.{$index}.description") <div class="text-danger">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Section: Inclusions -->
                            <h5 class="card-title mb-4 mt-4">Tour Inclusions / Exclusions</h5>
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-outline-success mb-2" wire:click="addInclusion">+ Add Item</button>
                                @foreach($inclusions as $index => $inc)
                                    <div class="card mb-2">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <span>Inclusion {{ $index + 1 }}</span>
                                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeInclusion({{ $index }})">Remove</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select wire:model.defer="inclusions.{{ $index }}.type" class="form-control">
                                                        <option value="included">Included</option>
                                                        <option value="not_included">Not Included</option>
                                                    </select>
                                                    @error("inclusions.{$index}.type") <div class="text-danger">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" wire:model.defer="inclusions.{{ $index }}.item" class="form-control" placeholder="Item Description">
                                                    @error("inclusions.{$index}.item") <div class="text-danger">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Section: Accommodations -->
                            <h5 class="card-title mb-4 mt-4">Tour Accommodations</h5>
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-outline-success mb-2" wire:click="addAccommodation">+ Add Accommodation</button>
                                @foreach($accommodations as $index => $acc)
                                    <div class="card mb-2">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <span>Accommodation {{ $index + 1 }}</span>
                                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeAccommodation({{ $index }})">Remove</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" wire:model.defer="accommodations.{{ $index }}.location" class="form-control" placeholder="Location">
                                                    @error("accommodations.{$index}.location") <div class="text-danger">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="number" wire:model.defer="accommodations.{{ $index }}.nights_count" class="form-control" placeholder="Nights Count" min="1">
                                                    @error("accommodations.{$index}.nights_count") <div class="text-danger">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <input type="text" wire:model.defer="accommodations.{{ $index }}.standard_options" class="form-control" placeholder="Standard Options">
                                                    @error("accommodations.{$index}.standard_options") <div class="text-danger">{{ $message }}</div> @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" wire:model.defer="accommodations.{{ $index }}.comfort_options" class="form-control" placeholder="Comfort Options">
                                                    @error("accommodations.{$index}.comfort_options") <div class="text-danger">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Buttons -->
                            <div class="form-group mb-0">
                                <button type="submit"
                                        class="btn btn-success waves-effect waves-light mr-2">
                                    {{--<i class="bx bx-check-double font-size-16 align-middle mr-1"></i>--}} <!-- Заменим иконку -->
                                    <i class="fas fa-save font-size-16 align-middle mr-1"></i> <!-- Используем Font Awesome -->
                                    Save
                                </button>
                                <a href="{{ route('tours.index') }}"
                                   class="btn btn-secondary waves-effect waves-light">
                                    {{--<i class="bx bx-x font-size-16 align-middle mr-1"></i>--}} <!-- Заменим иконку -->
                                    <i class="fas fa-times font-size-16 align-middle mr-1"></i> <!-- Используем Font Awesome -->
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Изображение и публикация -->
            <div class="col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <!-- Image -->
                        <div class="form-group">
                            <label for="image">Select Image</label>
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input @error('image') is-invalid @enderror"
                                       id="image"
                                       wire:model="image"
                                       accept="image/*">
                                <label class="custom-file-label" for="image">
                                    @if ($image)
                                        {{ $image->getClientOriginalName() }}
                                    @else
                                        Select Image
                                    @endif
                                </label>
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Preview Container -->
                        <div class="position-relative mb-3" style="height:200px;">
                            <!-- Loading Spinner -->
{{--                            <div wire:loading wire:target="image" class="d-flex justify-content-center align-items-center" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8);">--}}
{{--                                <div class="spinner-border text-primary" role="status">--}}
{{--                                    <span class="sr-only">Loading...</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <!-- Image or Placeholder -->
                            <div wire:loading.remove wire:target="image">
                                @if ($image)
                                    <!-- Temporary Preview -->
                                    <img class="img-fluid rounded"
                                         style="max-height:200px; object-fit:cover;"
                                         src="{{ $image->temporaryUrl() }}"
                                         alt="Preview">
                                @else
                                    <!-- Placeholder -->
                                    <img class="img-fluid rounded"
                                         style="max-height:200px; object-fit:cover;"
                                         src="{{ asset('assets/images/media/sm-5.jpg') }}"
                                         alt="Placeholder">
                                @endif
                            </div>
                        </div>

                        <!-- Is Published -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="is_published"
                                       wire:model.defer="is_published">
                                <label class="custom-control-label" for="is_published">Is Published</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('summernote-css')
    <link rel="stylesheet" href="{{ asset('assets/css/summernote-bs4.min.css') }}">
@endpush

@push('summernote-js')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {
            // Инициализируем Summernote один раз при загрузке компонента
            // Используем wire:ignore, чтобы Livewire не трогал DOM Summernote напрямую
            let summernoteElement = $('#summernote-content');
            if(summernoteElement.length && !summernoteElement.summernote('hasFocus')) { // Проверяем, что элемент существует и не инициализирован
                summernoteElement.summernote({
                    placeholder: 'Enter short description...',
                    tabsize: 2,
                    height: 100,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link']], // Убрана картинка, если не нужна
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    callbacks: {
                        onChange: function(contents, $editable) {
                            // console.log(contents); // Опционально
                            // Синхронизация данных: при каждом изменении содержимого
                            // вызываем метод set Livewire, чтобы обновить свойство $content
                            // @this - это глобальная переменная Livewire для доступа к компоненту
                        @this.set('short_description', contents);
                        }
                    }
                });

                // Устанавливаем начальное значение, если оно есть
                // (например, если компонент был повторно инициализирован с ошибкой валидации)
                if (@this.short_description) {
                    summernoteElement.summernote('code', @this.short_description);
                }
            }
        });

        // Опционально: Уничтожаем Summernote перед тем, как Livewire обновит DOM (если это помогает)
        document.addEventListener('livewire:navigating', function () {
            let summernoteElement = $('#summernote-content');
            if(summernoteElement.length && summernoteElement.summernote('initialized')) {
                summernoteElement.summernote('destroy');
            }
        });

        // Или, если используется старая версия Livewire без livewire:navigating:
        // window.addEventListener('beforeunload', function(e) {
        //     let summernoteElement = $('#summernote-content');
        //     if(summernoteElement.length && summernoteElement.summernote('initialized')) {
        //         summernoteElement.summernote('destroy');
        //     }
        // });

    </script>
@endpush

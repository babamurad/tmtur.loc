<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Создать тур</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Туры</a></li>
                        <li class="breadcrumb-item active">Создание</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Основная информация -->
            <div class="col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Детали тура</h5>
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form wire:submit.prevent="save">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Название <span class="text-danger">*</span></label>
                                        <span>Оригинал на русском языке</span>
                                        <input type="text" wire:model.debounce.300ms="title"
                                               class="form-control @error('title') is-invalid @enderror">
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Slug: {{ $slug }}</small>
                                    </div>
                                </div>

                                {{-- ПЕРЕВОДЫ title --}}
                                @foreach(config('app.available_locales') as $locale)
                                    @continue($locale === config('app.fallback_locale'))
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Название ({{ strtoupper($locale) }})<span class="text-danger">*</span></label>
                                            <input type="text"
                                                   wire:model.defer="trans.{{ $locale }}.title"
                                                   class="form-control"
                                                   placeholder="Перевод на {{ $locale }}">
                                            @error("trans.$locale.title") <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Base Price -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="base_price_cents">Цена $ <span class="text-danger">*</span></label>
                                        <input type="number"
                                               wire:model.defer="base_price_cents"
                                               class="form-control @error('base_price_cents') is-invalid @enderror"
                                               placeholder="например 150">
                                        @error('base_price_cents')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Duration Days -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="duration_days">Длительность (дней) <span class="text-danger">*</span></label>
                                        <input type="number"
                                               wire:model.defer="duration_days"
                                               class="form-control @error('duration_days') is-invalid @enderror"
                                               placeholder="например, 5">
                                        @error('duration_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group mb-0" wire:ignore>
                                        <label>Категория<span class="text-danger">*</span></label>

                                        <select class="form-control select2 @error('category_id') is-invalid @enderror"
                                        wire:model.defer="category_id"
                                        name="states[]"
                                        multiple="multiple">
                                            <option data-select2-id="3">Select</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @error('category_id')
                                    <div class="invalid-feedback d-block mt-0">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- fallback-язык = оригинал --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Краткое описание ({{ strtoupper(config('app.fallback_locale')) }})</label>
                                        <x-quill wire:model.defer="trans.{{ config('app.fallback_locale') }}.short_description" />

                                    </div>
                                    @error("trans." . config('app.fallback_locale') . ".short_description")
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- остальные языки --}}
                                @foreach(config('app.available_locales') as $locale)
                                    @continue($locale === config('app.fallback_locale'))
                                    <div class="col-md-12">
                                        <label>Краткое описание ({{ strtoupper($locale) }})</label>
                                        <x-quill wire:model.defer="trans.{{ $locale }}.short_description" />
                                    </div>
                                @endforeach
                            </div>


                            <!-- Buttons -->
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="fas fa-save font-size-16 align-middle mr-1"></i>Сохранить
                                </button>
                                <a href="{{ route('tours.index') }}" class="btn btn-secondary waves-effect waves-light">
                                    <i class="fas fa-times font-size-16 align-middle mr-1"></i>Отмена
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
                        <div class="form-group">
                            <label for="image">Изображение</label>
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input @error('image') is-invalid @enderror"
                                       id="image"
                                       wire:model="image"
                                       accept="image/*">
                                <label class="custom-file-label" for="image">
                                    {{ $image ? $image->getClientOriginalName() : 'Выберите файл' }}
                                </label>
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Preview -->
                        <div class="position-relative mb-3" style="height:200px;">
                            <div wire:loading.remove wire:target="image">
                                @if ($image)
                                    <img class="img-fluid rounded" style="max-height:200px;object-fit:cover;" src="{{ $image->temporaryUrl() }}" alt="Preview">
                                @else
                                    <img class="img-fluid rounded" style="max-height:200px;object-fit:cover;" src="{{ asset('assets/images/media/sm-5.jpg') }}" alt="Placeholder">
                                @endif
                            </div>
                        </div>

                        <!-- Is Published -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_published" wire:model.defer="is_published">
                                <label class="custom-control-label" for="is_published">Опубликовано</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <!-- Section: Itinerary Days -->
                        <h5 class="card-title mb-4 mt-4">Программа тура</h5>
                        <div class="form-group">
                            <button type="button" class="btn btn-sm btn-outline-success mb-2" wire:click="addItineraryDay">+ Добавить день</button>
                            @foreach($itinerary_days as $index => $day)
                                <div class="card mb-2">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span>День {{ $index + 1 }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeItineraryDay({{ $index }})">Удалить</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="number" wire:model.defer="itinerary_days.{{ $index }}.day_number" class="form-control" placeholder="№" min="1">
                                                @error("itinerary_days.{$index}.day_number") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" wire:model.defer="itinerary_days.{{ $index }}.title" class="form-control" placeholder="Заголовок дня">
                                                @error("itinerary_days.{$index}.title") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <textarea wire:model.defer="itinerary_days.{{ $index }}.description" class="form-control" placeholder="Описание дня" rows="8"></textarea>
                                                @error("itinerary_days.{$index}.description") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Section: Inclusions -->
                        <h5 class="card-title mb-4 mt-4">Что включено / не включено</h5>
                        <div class="form-group">
                            <button type="button" class="btn btn-sm btn-outline-success mb-2" wire:click="addInclusion">+ Добавить пункт</button>
                            @foreach($inclusions as $index => $inc)
                                <div class="card mb-2">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span>Пункт {{ $index + 1 }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeInclusion({{ $index }})">Удалить</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select wire:model.defer="inclusions.{{ $index }}.type" class="form-control">
                                                    <option value="included">Включено</option>
                                                    <option value="not_included">Не включено</option>
                                                </select>
                                                @error("inclusions.{$index}.type") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" wire:model.defer="inclusions.{{ $index }}.item" class="form-control" placeholder="Описание">
                                                @error("inclusions.{$index}.item") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Section: Accommodations -->
                        <h5 class="card-title mb-4 mt-4">Размещение</h5>
                        <div class="form-group">
                            <button type="button" class="btn btn-sm btn-outline-success mb-2" wire:click="addAccommodation">+ Добавить отель</button>
                            @foreach($accommodations as $index => $acc)
                                <div class="card mb-2">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span>Отель {{ $index + 1 }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeAccommodation({{ $index }})">Удалить</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" wire:model.defer="accommodations.{{ $index }}.location" class="form-control" placeholder="Локация">
                                                @error("accommodations.{$index}.location") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" wire:model.defer="accommodations.{{ $index }}.nights_count" class="form-control" placeholder="Кол-во ночей" min="1">
                                                @error("accommodations.{$index}.nights_count") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <input type="text" wire:model.defer="accommodations.{{ $index }}.standard_options" class="form-control" placeholder="Стандарт">
                                                @error("accommodations.{$index}.standard_options") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" wire:model.defer="accommodations.{{ $index }}.comfort_options" class="form-control" placeholder="Комфорт">
                                                @error("accommodations.{$index}.comfort_options") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('select2')
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
        <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>--}}
@endpush
{{-- Quill CSS --}}
@push('quill-css')
    <link href="{{ asset('vendor/livewire-quill/quill.snow.min.css') }}" rel="stylesheet">
@endpush

{{-- Quill JS + инициализация --}}
@push('quill-js')
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            let select2 = $('.select2');
            select2.select2();
            select2.on('change', function (e) {
                // console.log($(this).val);
                let data = $(this).val() || [];
                @this.set('category_id', data);
            });
        });
    </script>

    <script src="{{ asset('vendor/livewire-quill/quill.js') }}"></script>


@endpush

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Создать тур</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.tours.index') }}">Туры</a></li>
                        <li class="breadcrumb-item active">Создание</li>
                    </ol>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save">
            <div class="row">
                {{-- Main Content Column --}}
                <div class="col-lg-8">
                    {{-- Multilingual Content Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-edit-alt font-size-18 align-middle mr-1 text-primary"></i>
                                Основная информация
                            </h5>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Language Tabs --}}
                            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#lang-{{ config('app.fallback_locale') }}" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">{{ strtoupper(config('app.fallback_locale')) }}</span>
                                    </a>
                                </li>
                                @foreach(config('app.available_locales') as $locale)
                                    @continue($locale === config('app.fallback_locale'))
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#lang-{{ $locale }}" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">{{ strtoupper($locale) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Tab Content --}}
                            <div class="tab-content">
                                {{-- Default Language Tab --}}
                                <div class="tab-pane active" id="lang-{{ config('app.fallback_locale') }}" role="tabpanel">
                                    <div class="form-group">
                                        <label for="title">Название <span class="text-danger">*</span></label>
                                        <input type="text"
                                            id="title"
                                            wire:model.debounce.300ms="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Введите название тура">
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <small class="form-text text-muted">Slug: {{ $slug }}</small>
                                    </div>

                                    <div class="form-group">
                                        <label>Краткое описание</label>
                                        <x-quill wire:model.defer="trans.{{ config('app.fallback_locale') }}.short_description" />
                                        @error("trans." . config('app.fallback_locale') . ".short_description")
                                        <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Other Language Tabs --}}
                                @foreach(config('app.available_locales') as $locale)
                                    @continue($locale === config('app.fallback_locale'))
                                    <div class="tab-pane" id="lang-{{ $locale }}" role="tabpanel">
                                        <div class="form-group">
                                            <label>Название <span class="text-danger">*</span></label>
                                            <input type="text"
                                                   wire:model.defer="trans.{{ $locale }}.title"
                                                   class="form-control"
                                                   placeholder="Название на {{ strtoupper($locale) }}">
                                            @error("trans.$locale.title") <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Краткое описание</label>
                                            <x-quill wire:model.defer="trans.{{ $locale }}.short_description" />
                                            @error("trans.$locale.short_description")
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Tour Details Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-info-circle font-size-18 align-middle mr-1 text-primary"></i>
                                Детали тура
                            </h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="base_price_cents">Цена $ <span class="text-danger">*</span></label>
                                        <input type="number"
                                               id="base_price_cents"
                                               wire:model.defer="base_price_cents"
                                               class="form-control @error('base_price_cents') is-invalid @enderror"
                                               placeholder="150">
                                        @error('base_price_cents')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="duration_days">Длительность (дней) <span class="text-danger">*</span></label>
                                        <input type="number"
                                               id="duration_days"
                                               wire:model.defer="duration_days"
                                               class="form-control @error('duration_days') is-invalid @enderror"
                                               placeholder="5">
                                        @error('duration_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" wire:ignore>
                                        <label>Категория <span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('category_id') is-invalid @enderror"
                                                wire:model.defer="category_id"
                                                name="states[]"
                                                multiple="multiple">
                                            <option>Выберите категорию</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Itinerary Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-list-ul font-size-18 align-middle mr-1 text-primary"></i>
                                Программа тура
                            </h5>
                            <button type="button" class="btn btn-sm btn-outline-success mb-3" wire:click="addItineraryDay">
                                <i class="bx bx-plus"></i> Добавить день
                            </button>
                            
                            @foreach($itinerary_days as $index => $day)
                                <div class="card border mb-2">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                        <strong>День {{ $index + 1 }}</strong>
                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeItineraryDay({{ $index }})">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <label class="form-label">Номер дня</label>
                                                <input type="number" 
                                                       wire:model.defer="itinerary_days.{{ $index }}.day_number" 
                                                       class="form-control form-control-sm" 
                                                       placeholder="№" 
                                                       min="1">
                                                @error("itinerary_days.{$index}.day_number") 
                                                <div class="text-danger small">{{ $message }}</div> 
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Language Tabs --}}
                                        <ul class="nav nav-tabs nav-tabs-custom mb-2" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#day-{{ $index }}-lang-{{ config('app.fallback_locale') }}" role="tab">
                                                    <span class="d-none d-sm-block">{{ strtoupper(config('app.fallback_locale')) }}</span>
                                                </a>
                                            </li>
                                            @foreach(config('app.available_locales') as $locale)
                                                @continue($locale === config('app.fallback_locale'))
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#day-{{ $index }}-lang-{{ $locale }}" role="tab">
                                                        <span class="d-none d-sm-block">{{ strtoupper($locale) }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        {{-- Tab Content --}}
                                        <div class="tab-content">
                                            {{-- Default Language Tab --}}
                                            <div class="tab-pane active" id="day-{{ $index }}-lang-{{ config('app.fallback_locale') }}" role="tabpanel">
                                                <div class="form-group">
                                                    <label>Заголовок <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           wire:model.defer="itinerary_days.{{ $index }}.trans.{{ config('app.fallback_locale') }}.title" 
                                                           class="form-control form-control-sm" 
                                                           placeholder="Заголовок дня">
                                                    @error("itinerary_days.{$index}.trans.".config('app.fallback_locale').".title") 
                                                    <div class="text-danger small">{{ $message }}</div> 
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Описание</label>
                                                    <textarea wire:model.defer="itinerary_days.{{ $index }}.trans.{{ config('app.fallback_locale') }}.description" 
                                                              class="form-control form-control-sm" 
                                                              placeholder="Описание дня" 
                                                              rows="3"></textarea>
                                                    @error("itinerary_days.{$index}.trans.".config('app.fallback_locale').".description") 
                                                    <div class="text-danger small">{{ $message }}</div> 
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Other Language Tabs --}}
                                            @foreach(config('app.available_locales') as $locale)
                                                @continue($locale === config('app.fallback_locale'))
                                                <div class="tab-pane" id="day-{{ $index }}-lang-{{ $locale }}" role="tabpanel">
                                                    <div class="form-group">
                                                        <label>Заголовок <span class="text-danger">*</span></label>
                                                        <input type="text" 
                                                               wire:model.defer="itinerary_days.{{ $index }}.trans.{{ $locale }}.title" 
                                                               class="form-control form-control-sm" 
                                                               placeholder="Заголовок на {{ strtoupper($locale) }}">
                                                        @error("itinerary_days.{$index}.trans.{$locale}.title") 
                                                        <div class="text-danger small">{{ $message }}</div> 
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Описание</label>
                                                        <textarea wire:model.defer="itinerary_days.{{ $index }}.trans.{{ $locale }}.description" 
                                                                  class="form-control form-control-sm" 
                                                                  placeholder="Описание на {{ strtoupper($locale) }}" 
                                                                  rows="3"></textarea>
                                                        @error("itinerary_days.{$index}.trans.{$locale}.description") 
                                                        <div class="text-danger small">{{ $message }}</div> 
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Inclusions Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-check-circle font-size-18 align-middle mr-1 text-primary"></i>
                                Что включено / не включено
                            </h5>
                            <button type="button" class="btn btn-sm btn-outline-success mb-3" wire:click="addInclusion">
                                <i class="bx bx-plus"></i> Добавить пункт
                            </button>
                            
                            @foreach($inclusions as $index => $inc)
                                <div class="card border mb-2">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                        <strong>Пункт {{ $index + 1 }}</strong>
                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeInclusion({{ $index }})">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label class="form-label">Включение</label>
                                                <select wire:model.defer="inclusions.{{ $index }}.inclusion_id" class="form-control form-control-sm">
                                                    <option value="">Выберите...</option>
                                                    @foreach($available_inclusions as $availInc)
                                                        <option value="{{ $availInc->id }}">
                                                            {{ $availInc->tr('title') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error("inclusions.{$index}.inclusion_id") 
                                                <div class="text-danger small">{{ $message }}</div> 
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Тип</label>
                                                <select wire:model.defer="inclusions.{{ $index }}.is_included" class="form-control form-control-sm">
                                                    <option value="1">Включено</option>
                                                    <option value="0">Не включено</option>
                                                </select>
                                                @error("inclusions.{$index}.is_included") 
                                                <div class="text-danger small">{{ $message }}</div> 
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Accommodations Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-hotel font-size-18 align-middle mr-1 text-primary"></i>
                                Размещение
                            </h5>
                            <button type="button" class="btn btn-sm btn-outline-success mb-3" wire:click="addAccommodation">
                                <i class="bx bx-plus"></i> Добавить отель
                            </button>
                            
                            @foreach($accommodations as $index => $acc)
                                <div class="card border mb-2">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                        <strong>Отель {{ $index + 1 }}</strong>
                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeAccommodation({{ $index }})">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <label class="form-label">Количество ночей <span class="text-danger">*</span></label>
                                                <input type="number" 
                                                       wire:model.defer="accommodations.{{ $index }}.nights_count" 
                                                       class="form-control form-control-sm" 
                                                       placeholder="Кол-во ночей" 
                                                       min="1">
                                                @error("accommodations.{$index}.nights_count") 
                                                <div class="text-danger small">{{ $message }}</div> 
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Language Tabs --}}
                                        <ul class="nav nav-tabs nav-tabs-custom mb-2" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#acc-{{ $index }}-lang-{{ config('app.fallback_locale') }}" role="tab">
                                                    <span class="d-none d-sm-block">{{ strtoupper(config('app.fallback_locale')) }}</span>
                                                </a>
                                            </li>
                                            @foreach(config('app.available_locales') as $locale)
                                                @continue($locale === config('app.fallback_locale'))
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#acc-{{ $index }}-lang-{{ $locale }}" role="tab">
                                                        <span class="d-none d-sm-block">{{ strtoupper($locale) }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        {{-- Tab Content --}}
                                        <div class="tab-content">
                                            {{-- Default Language Tab --}}
                                            <div class="tab-pane active" id="acc-{{ $index }}-lang-{{ config('app.fallback_locale') }}" role="tabpanel">
                                                <div class="form-group">
                                                    <label>Локация <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           wire:model.defer="accommodations.{{ $index }}.trans.{{ config('app.fallback_locale') }}.location" 
                                                           class="form-control form-control-sm" 
                                                           placeholder="Локация">
                                                    @error("accommodations.{$index}.trans.".config('app.fallback_locale').".location") 
                                                    <div class="text-danger small">{{ $message }}</div> 
                                                    @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Стандарт</label>
                                                            <input type="text" 
                                                                   wire:model.defer="accommodations.{{ $index }}.trans.{{ config('app.fallback_locale') }}.standard_options" 
                                                                   class="form-control form-control-sm" 
                                                                   placeholder="Стандарт">
                                                            @error("accommodations.{$index}.trans.".config('app.fallback_locale').".standard_options") 
                                                            <div class="text-danger small">{{ $message }}</div> 
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Комфорт</label>
                                                            <input type="text" 
                                                                   wire:model.defer="accommodations.{{ $index }}.trans.{{ config('app.fallback_locale') }}.comfort_options" 
                                                                   class="form-control form-control-sm" 
                                                                   placeholder="Комфорт">
                                                            @error("accommodations.{$index}.trans.".config('app.fallback_locale').".comfort_options") 
                                                            <div class="text-danger small">{{ $message }}</div> 
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Other Language Tabs --}}
                                            @foreach(config('app.available_locales') as $locale)
                                                @continue($locale === config('app.fallback_locale'))
                                                <div class="tab-pane" id="acc-{{ $index }}-lang-{{ $locale }}" role="tabpanel">
                                                    <div class="form-group">
                                                        <label>Локация <span class="text-danger">*</span></label>
                                                        <input type="text" 
                                                               wire:model.defer="accommodations.{{ $index }}.trans.{{ $locale }}.location" 
                                                               class="form-control form-control-sm" 
                                                               placeholder="Локация на {{ strtoupper($locale) }}">
                                                        @error("accommodations.{$index}.trans.{$locale}.location") 
                                                        <div class="text-danger small">{{ $message }}</div> 
                                                        @enderror
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Стандарт</label>
                                                                <input type="text" 
                                                                       wire:model.defer="accommodations.{{ $index }}.trans.{{ $locale }}.standard_options" 
                                                                       class="form-control form-control-sm" 
                                                                       placeholder="Стандарт на {{ strtoupper($locale) }}">
                                                                @error("accommodations.{$index}.trans.{$locale}.standard_options") 
                                                                <div class="text-danger small">{{ $message }}</div> 
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Комфорт</label>
                                                                <input type="text" 
                                                                       wire:model.defer="accommodations.{{ $index }}.trans.{{ $locale }}.comfort_options" 
                                                                       class="form-control form-control-sm" 
                                                                       placeholder="Комфорт на {{ strtoupper($locale) }}">
                                                                @error("accommodations.{$index}.trans.{$locale}.comfort_options") 
                                                                <div class="text-danger small">{{ $message }}</div> 
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Sidebar Column --}}
                <div class="col-lg-4">
                    {{-- Image Gallery Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-images font-size-18 align-middle mr-1 text-primary"></i>
                                Галерея изображений
                            </h5>
                            
                            {{-- Upload Progress Indicator --}}
                            <div wire:loading wire:target="images" class="mb-3">
                                <div class="alert alert-info mb-2">
                                    <i class="bx bx-loader bx-spin font-size-16 align-middle mr-1"></i>
                                    <strong>Загрузка изображений...</strong>
                                    <p class="mb-0 mt-1"><small>Пожалуйста, подождите. Не закрывайте страницу и не нажимайте другие кнопки.</small></p>
                                </div>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                                         role="progressbar" 
                                         style="width: 100%"
                                         aria-valuenow="100" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        <span class="font-weight-bold">Обработка файлов...</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Выберите изображения</label>
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input @error('images.*') is-invalid @enderror"
                                        id="images"
                                        wire:model="images"
                                        accept="image/*"
                                        multiple
                                        wire:loading.attr="disabled"
                                        wire:target="images">
                                    <label class="custom-file-label" for="images">
                                        @if ($images && count($images) > 0)
                                            Выбрано файлов: {{ count($images) }}
                                        @else
                                            Выберите файлы
                                        @endif
                                    </label>
                                    @error('images.*')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    Первое изображение будет главным. Можно выбрать несколько файлов.
                                </small>
                            </div>

                            @if ($images && count($images) > 0)
                                <div class="mt-3">
                                    <p class="text-muted mb-2"><small>Предпросмотр ({{ count($images) }} изображений):</small></p>
                                    <div class="row">
                                        @foreach($images as $index => $image)
                                            <div class="col-6 col-md-4 mb-3">
                                                <div class="position-relative">
                                                    <img src="{{ $image->temporaryUrl() }}" 
                                                         class="img-fluid rounded shadow-sm {{ $index === 0 ? 'border border-primary border-3' : '' }}" 
                                                         alt="Preview {{ $index + 1 }}">
                                                    @if($index === 0)
                                                        <span class="badge badge-primary position-absolute" style="top: 5px; left: 5px;">
                                                            <i class="bx bx-star"></i> Главное
                                                        </span>
                                                    @endif
                                                    <small class="d-block text-center mt-1 text-muted">
                                                        {{ $index + 1 }}. {{ Str::limit($image->getClientOriginalName(), 20) }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="mt-3 text-center p-4 bg-light rounded">
                                    <i class="bx bx-image-add font-size-48 text-muted"></i>
                                    <p class="text-muted mb-0 mt-2">Изображения не выбраны</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Settings Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-cog font-size-18 align-middle mr-1 text-primary"></i>
                                Настройки
                            </h5>

                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                        class="custom-control-input"
                                        id="is_published"
                                        wire:model.defer="is_published">
                                    <label class="custom-control-label" for="is_published">
                                        <strong>Опубликовано</strong>
                                        <br>
                                        <small class="text-muted">Показывать тур на сайте</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="card">
                        <div class="card-body">
                            <button type="submit"
                                    class="btn btn-success btn-block waves-effect waves-light"
                                    wire:loading.attr="disabled"
                                    wire:target="images">
                                <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                <span wire:loading.remove wire:target="images">Сохранить</span>
                                <span wire:loading wire:target="images">
                                    <i class="bx bx-loader bx-spin"></i> Загрузка изображений...
                                </span>
                            </button>
                            <a href="{{ route('admin.tours.index') }}"
                               class="btn btn-secondary btn-block waves-effect waves-light mt-2"
                               wire:loading.attr="disabled"
                               wire:target="images">
                                <i class="bx bx-x font-size-16 align-middle mr-1"></i>
                                Отмена
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('select2')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('quill-css')
    <link href="{{ asset('vendor/livewire-quill/quill.snow.min.css') }}" rel="stylesheet">
@endpush

@push('quill-js')
    <script src="{{ asset('vendor/livewire-quill/quill.js') }}"></script>
    <script>
        $(document).ready(function() {
            let select2 = $('.select2');
            select2.select2();
            select2.on('change', function (e) {
                let data = $(this).val() || [];
                @this.set('category_id', data);
            });
        });
    </script>
@endpush

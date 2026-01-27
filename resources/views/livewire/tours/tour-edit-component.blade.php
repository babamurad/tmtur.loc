<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Редактировать тур</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.tours.index') }}">Туры</a></li>
                        <li class="breadcrumb-item active">Редактирование</li>
                    </ol>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="saveAndClose">
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
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Language Tabs --}}
                            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                @foreach(config('app.available_locales') as $locale)
                                    <li class="nav-item">
                                        <a class="nav-link @if($loop->first) active @endif @if($errors->has("trans.$locale.*") || ($loop->first && $errors->has('title'))) text-danger @endif" 
                                           data-toggle="tab" 
                                           href="#lang-{{ $locale }}" 
                                           role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">{{ strtoupper($locale) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- AI Translation Buttons --}}
                            <x-gemini-translation-buttons :duration="$last_translation_duration" />
                            
                            {{-- Tab Content --}}
                            <div class="tab-content">
                                @foreach(config('app.available_locales') as $locale)
                                    <div class="tab-pane @if($loop->first) active @endif" id="lang-{{ $locale }}" role="tabpanel">
                                        <div class="form-group">
                                            <label>Название @if($loop->first)<span class="text-danger">*</span>@endif</label>
                                            
                                            {{-- Если это первый язык (обычно RU или Fallback), привязываем к основным полям --}}
                                            @if($locale === config('app.fallback_locale'))
                                                <input type="text"
                                                    id="title"
                                                    wire:model.debounce.300ms="title"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    placeholder="Введите название тура">
                                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                <small class="form-text text-muted">Slug: {{ $slug }}</small>
                                            @else
                                                <input type="text"
                                                       wire:model="trans.{{ $locale }}.title"
                                                       class="form-control"
                                                       placeholder="Название на {{ strtoupper($locale) }}">
                                                @error("trans.$locale.title") <span class="text-danger small">{{ $message }}</span> @enderror
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label>Краткое описание</label>
                                            @if($locale === config('app.fallback_locale') && isset($short_description))
                                                 {{-- For Create Component which has public $short_description --}}
                                                <x-quill wire:model.defer="short_description" />
                                                @error('short_description')<span class="text-danger small">{{ $message }}</span>@enderror
                                            @elseif($locale === config('app.fallback_locale'))
                                                {{-- For Edit Component or if public prop missing, use trans --}}
                                                <x-quill wire:model.defer="trans.{{ $locale }}.short_description" />
                                                 @error("trans.$locale.short_description")<span class="text-danger small">{{ $message }}</span>@enderror
                                            @else
                                                <x-quill wire:model.defer="trans.{{ $locale }}.short_description" />
                                                @error("trans.$locale.short_description")
                                                <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            @endif
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
                                <div class="col-md-3">
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

                                <div class="col-md-3">
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

                                <div class="col-md-6">
                                    <div class="form-group" wire:ignore>
                                        <label for="category_ids_select2">Категория <span class="text-danger">*</span></label>
                                        <select id="category_ids_select2"
                                                class="form-control select2"
                                                data-model="category_id"
                                                data-placeholder="Выберите категорию"
                                                name="category_id[]"
                                                multiple="multiple"
                                                x-data
                                                x-init="
                                                    $($el).select2({
                                                       placeholder: 'Выберите категорию'
                                                    });
                                                    $($el).on('change', function (e) {
                                                        @this.set('category_id', $($el).val());
                                                    });
                                                ">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                        @if(in_array($category->id, $category_id)) selected @endif>
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
                        <div class="card-header pointer-cursor d-flex justify-content-between align-items-center" 
                             data-toggle="collapse" 
                             data-target="#programCollapse" 
                             aria-expanded="true" 
                             style="cursor: pointer;">
                            <h5 class="card-title mb-0 @if($errors->has('itinerary_days.*')) text-danger @endif">
                                <i class="bx bx-list-ul font-size-18 align-middle mr-1 text-primary"></i>
                                Программа тура @if($errors->has('itinerary_days.*')) <i class="bx bx-error-circle"></i> @endif
                            </h5>
                            <i class="bx bx-chevron-down font-size-18"></i>
                        </div>
                        <div id="programCollapse" class="collapse show">
                            <div class="card-body">
                                <button type="button" class="btn btn-sm btn-outline-success mb-3" wire:click="addItineraryDay">
                                    <i class="bx bx-plus"></i> Добавить день
                                </button>
                                
                                @foreach($itinerary_days as $index => $day)
                                    <div class="card border mb-2 @if($errors->has("itinerary_days.$index.*")) border-danger @endif">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                            <strong class="@if($errors->has("itinerary_days.$index.*")) text-danger @endif">День {{ $index + 1 }}</strong>
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
                                                        class="form-control form-control-sm" placeholder="№" min="1">
                                                    @error("itinerary_days.{$index}.day_number")
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">Локация</label>
                                                    <select wire:model.live="itinerary_days.{{ $index }}.location_id" class="form-control form-control-sm">
                                                        <option value="">Выберите локацию...</option>
                                                        @foreach($locations as $loc)
                                                            <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                @php
                                                    $currentLocId = $itinerary_days[$index]['location_id'] ?? null;
                                                    $currentLoc = $locations->find($currentLocId);
                                                    $places = $currentLoc ? $currentLoc->places : [];
                                                    $hotels = $currentLoc ? $currentLoc->hotels : [];
                                                @endphp

                                                @if($currentLoc)
                                                    <div class="col-md-4">
                                                        <label class="form-label">Места для посещения</label>
                                                        <div class="border rounded p-2 bg-white" style="max-height: 150px; overflow-y: auto;">
                                                            @forelse($places as $place)
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           id="edit-place-{{ $index }}-{{ $place->id }}"
                                                                           wire:model.defer="itinerary_days.{{ $index }}.place_ids"
                                                                           value="{{ $place->id }}">
                                                                    <label class="custom-control-label" for="edit-place-{{ $index }}-{{ $place->id }}">
                                                                        {{ $place->name }}
                                                                    </label>
                                                                </div>
                                                            @empty
                                                                <small class="text-muted">Нет мест</small>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Отели (Список)</label>
                                                        <div class="border rounded p-2 bg-white" style="max-height: 150px; overflow-y: auto;">
                                                            @forelse($hotels as $hotel)
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                           id="edit-hotel-{{ $index }}-{{ $hotel->id }}"
                                                                           wire:model.defer="itinerary_days.{{ $index }}.hotel_ids"
                                                                           value="{{ $hotel->id }}">
                                                                    <label class="custom-control-label" for="edit-hotel-{{ $index }}-{{ $hotel->id }}">
                                                                        {{ $hotel->name }}
                                                                    </label>
                                                                </div>
                                                            @empty
                                                                <small class="text-muted">Нет отелей</small>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
    
                                            {{-- Language Tabs --}}
                                            <ul class="nav nav-tabs nav-tabs-custom mb-2" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active @if($errors->has("itinerary_days.$index.trans.".config('app.fallback_locale').".*")) text-danger @endif" data-toggle="tab" href="#edit-day-{{ $index }}-lang-{{ config('app.fallback_locale') }}" role="tab">
                                                        <span class="d-none d-sm-block">{{ strtoupper(config('app.fallback_locale')) }}</span>
                                                    </a>
                                                </li>
                                                @foreach(config('app.available_locales') as $locale)
                                                    @continue($locale === config('app.fallback_locale'))
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($errors->has("itinerary_days.$index.trans.$locale.*")) text-danger @endif" data-toggle="tab" href="#edit-day-{{ $index }}-lang-{{ $locale }}" role="tab">
                                                            <span class="d-none d-sm-block">{{ strtoupper($locale) }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
    
                                            {{-- Tab Content --}}
                                            <div class="tab-content">
                                                {{-- Default Language Tab --}}
                                                <div class="tab-pane active" id="edit-day-{{ $index }}-lang-{{ config('app.fallback_locale') }}" role="tabpanel">
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
                                                    <div class="tab-pane" id="edit-day-{{ $index }}-lang-{{ $locale }}" role="tabpanel">
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
                    </div>

                    {{-- Inclusions Section --}}
                    <div class="card">
                        <div class="card-header pointer-cursor d-flex justify-content-between align-items-center" 
                             data-toggle="collapse" 
                             data-target="#inclusionsCollapse" 
                             aria-expanded="false" 
                             style="cursor: pointer;">
                            <h5 class="card-title mb-0 @if($errors->has('inclusions.*')) text-danger @endif">
                                <i class="bx bx-check-circle font-size-18 align-middle mr-1 text-primary"></i>
                                Что включено / не включено @if($errors->has('inclusions.*')) <i class="bx bx-error-circle"></i> @endif
                            </h5>
                            <i class="bx bx-chevron-down font-size-18"></i>
                        </div>
                        <div id="inclusionsCollapse" class="collapse">
                            <div class="card-body">
                                <button type="button" class="btn btn-sm btn-outline-success mb-3" wire:click="addInclusion">
                                    <i class="bx bx-plus"></i> Добавить пункт
                                </button>
                                
                                @foreach($inclusions as $index => $inc)
                                    <div class="card border mb-2 @if($errors->has("inclusions.$index.*")) border-danger @endif">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                            <strong class="@if($errors->has("inclusions.$index.*")) text-danger @endif">Пункт {{ $index + 1 }}</strong>
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
                    </div>

                    {{-- Accommodations Section --}}
                    <div class="card">
                        <div class="card-header pointer-cursor d-flex justify-content-between align-items-center" 
                             data-toggle="collapse" 
                             data-target="#accommodationCollapse" 
                             aria-expanded="true" 
                             style="cursor: pointer;">
                            <h5 class="card-title mb-0 @if($errors->has('accommodations.*')) text-danger @endif">
                                <i class="bx bx-hotel font-size-18 align-middle mr-1 text-primary"></i>
                                Размещение @if($errors->has('accommodations.*')) <i class="bx bx-error-circle"></i> @endif
                            </h5>
                            <i class="bx bx-chevron-down font-size-18"></i>
                        </div>
                        <div id="accommodationCollapse" class="collapse show">
                            <div class="card-body">
                                <button type="button" class="btn btn-sm btn-outline-success mb-3" wire:click="addAccommodation">
                                    <i class="bx bx-plus"></i> Добавить отель
                                </button>
                                
                                @foreach($accommodations as $index => $acc)
                                    <div class="card border mb-2 @if($errors->has("accommodations.$index.*")) border-danger @endif">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                            <strong class="@if($errors->has("accommodations.$index.*")) text-danger @endif">Отель {{ $index + 1 }}</strong>
                                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeAccommodation({{ $index }})">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                        <div class="card-body" wire:key="acc-body-{{ $index }}-{{ $accommodations[$index]['location_id'] ?? 'null' }}">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label">Количество ночей <span class="text-danger">*</span></label>
                                                    <input type="number"
                                                        wire:model.defer="accommodations.{{ $index }}.nights_count"
                                                        class="form-control form-control-sm" placeholder="Кол-во ночей" min="1">
                                                    @error("accommodations.{$index}.nights_count")
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
    
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Локация <span class="text-danger">*</span></label>
                                                        <select wire:model.live="accommodations.{{ $index }}.location_id"
                                                            class="form-control form-control-sm">
                                                            <option value="">Выберите локацию</option>
                                                            @foreach($locations as $loc)
                                                                <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error("accommodations.{$index}.location_id")
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
    
                                                @php
                                                    $selectedLocId = $accommodations[$index]['location_id'] ?? null;
                                                    $selectedLoc = $locations->find($selectedLocId);
                                                @endphp
    
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Отель (Стандарт)</label>
                                                        <div wire:ignore>
                                                            <select wire:model.defer="accommodations.{{ $index }}.hotel_standard_ids"
                                                                data-model="accommodations.{{ $index }}.hotel_standard_ids"
                                                                class="form-control form-control-sm select2" multiple
                                                                x-data
                                                                x-init="
                                                                    $($el).select2({
                                                                        width: '100%'
                                                                    });
                                                                    $($el).on('change', function(){
                                                                        @this.set($($el).data('model'), $($el).val());
                                                                    });
                                                                ">
                                                                <option value="">Выберите...</option>
                                                                @if($selectedLoc)
                                                                    @foreach($selectedLoc->hotels as $hotel)
                                                                        @if($hotel->category?->value === 'standard')
                                                                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        @error("accommodations.{$index}.hotel_standard_ids")
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
    
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Отель (Комфорт)</label>
                                                        <div wire:ignore>
                                                            <select wire:model.defer="accommodations.{{ $index }}.hotel_comfort_ids"
                                                                data-model="accommodations.{{ $index }}.hotel_comfort_ids"
                                                                class="form-control form-control-sm select2" multiple
                                                                x-data
                                                                x-init="
                                                                    $($el).select2({
                                                                        width: '100%'
                                                                    });
                                                                    $($el).on('change', function(){
                                                                        @this.set($($el).data('model'), $($el).val());
                                                                    });
                                                                ">
                                                                <option value="">Выберите...</option>
                                                                @if($selectedLoc)
                                                                    @foreach($selectedLoc->hotels as $hotel)
                                                                        @if($hotel->category?->value === 'comfort')
                                                                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        @error("accommodations.{$index}.hotel_comfort_ids")
                                                            <div class="text-danger small">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Pricing Section --}}
                    <div class="card">
                        <div class="card-header pointer-cursor d-flex justify-content-between align-items-center" 
                             data-toggle="collapse" 
                             data-target="#pricingCollapse" 
                             aria-expanded="false" 
                             style="cursor: pointer;">
                            <h5 class="card-title mb-0">
                                <i class="bx bx-dollar-circle font-size-18 align-middle mr-1 text-primary"></i>
                                Ценообразование
                            </h5>
                            <i class="bx bx-chevron-down font-size-18"></i>
                        </div>
                        <div id="pricingCollapse" class="collapse">
                            <div class="card-body">
                                <livewire:admin.tours.tour-pricing-tab :tour="$tour" wire:key="tour-pricing-{{ $tour->id }}" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Column --}}
                <div class="col-lg-4">
                    {{-- SEO Settings Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-search-alt font-size-18 align-middle mr-1 text-primary"></i>
                                SEO настройки
                            </h5>

                            <div class="form-group">
                                <label for="seo_title">SEO Заголовок</label>
                                <input type="text"
                                       id="seo_title"
                                       wire:model.defer="seo_title"
                                       class="form-control @error('seo_title') is-invalid @enderror"
                                       placeholder="SEO Title">
                                @error('seo_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="seo_description">SEO Описание</label>
                                <textarea id="seo_description"
                                          wire:model.defer="seo_description"
                                          class="form-control @error('seo_description') is-invalid @enderror"
                                          rows="4"
                                          placeholder="SEO Description"></textarea>
                                @error('seo_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Image Gallery Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-images font-size-18 align-middle mr-1 text-primary"></i>
                                Галерея изображений
                            </h5>
                            
                            {{-- Existing Images --}}
                            @if(count($existingImages) > 0)
                                <div class="mb-4">
                                    <label class="d-block mb-2">Текущие изображения ({{ count($existingImages) }})</label>
                                    <div class="row">
                                        @foreach($existingImages as $img)
                                            <div class="col-6 col-md-4 mb-3">
                                                <div class="position-relative">
                                                    <img src="{{ $img['url'] }}" 
                                                         class="img-fluid rounded shadow-sm {{ $img['order'] === 0 ? 'border border-primary border-3' : '' }}" 
                                                         alt="{{ $img['file_name'] }}">
                                                    
                                                    @if($img['order'] === 0)
                                                        <span class="badge badge-primary position-absolute" style="top: 5px; left: 5px;">
                                                            <i class="bx bx-star"></i> Главное
                                                        </span>
                                                    @endif
                                                    
                                                    <div class="position-absolute" style="top: 5px; right: 5px;">
                                                        <button type="button" 
                                                                wire:click="deleteImage({{ $img['id'] }})"
                                                                class="btn btn-danger btn-sm"
                                                                title="Удалить">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="mt-2">
                                                        @if($img['order'] !== 0)
                                                            <button type="button" 
                                                                    wire:click="makeMain({{ $img['id'] }})"
                                                                    class="btn btn-outline-primary btn-sm btn-block">
                                                                <i class="bx bx-star"></i> Сделать главным
                                                            </button>
                                                        @endif
                                                        <small class="d-block text-center mt-1 text-muted">
                                                            {{ Str::limit($img['file_name'], 20) }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                            @else
                                <div class="alert alert-info">
                                    <i class="bx bx-info-circle"></i> У тура пока нет изображений
                                </div>
                            @endif
                            
                            {{-- Upload Progress Indicator --}}
                            <div wire:loading wire:target="newImages" class="mb-3">
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
                            
                            {{-- Upload New Images --}}
                            <div class="form-group">
                                <label>Загрузить новые изображения</label>
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input @error('newImages.*') is-invalid @enderror"
                                        id="newImages"
                                        wire:model="newImages"
                                        accept="image/*"
                                        multiple
                                        wire:loading.attr="disabled"
                                        wire:target="newImages">
                                    <label class="custom-file-label" for="newImages">
                                        @if ($newImages && count($newImages) > 0)
                                            Выбрано файлов: {{ count($newImages) }}
                                        @else
                                            Выберите файлы
                                        @endif
                                    </label>
                                    @error('newImages')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    @foreach($errors->get('newImages.*') as $messages)
                                        @foreach($messages as $msg)
                                            <div class="invalid-feedback d-block">{{ $msg }}</div>
                                            @break
                                        @endforeach
                                        @break
                                    @endforeach
                                </div>
                                <small class="form-text text-muted">
                                    Новые изображения будут добавлены в конец галереи
                                </small>
                            </div>

                            @if ($newImages && count($newImages) > 0)
                                <div class="mt-3">
                                    <p class="text-muted mb-2"><small>Предпросмотр новых ({{ count($newImages) }}):</small></p>
                                    <div class="row">
                                        @foreach($newImages as $index => $image)
                                            <div class="col-6 col-md-4 mb-3">
                                                <div class="position-relative">
                                                    <img src="{{ $image->temporaryUrl() }}" 
                                                         class="img-fluid rounded shadow-sm" 
                                                         alt="New {{ $index + 1 }}">
                                                    <span class="badge badge-success position-absolute" style="top: 5px; left: 5px;">
                                                        <i class="bx bx-plus"></i> Новое
                                                    </span>
                                                    <small class="d-block text-center mt-1 text-muted">
                                                        {{ Str::limit($image->getClientOriginalName(), 20) }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-purchase-tag-alt font-size-18 align-middle mr-1 text-primary"></i>
                                Теги
                            </h5>

                            <div class="form-group mb-0" wire:ignore>
                                <label for="tags_selected">Теги</label>
                                <select class="form-control select2" id="tags_selected"
                                    data-model="tags_selected" multiple="multiple"
                                    data-placeholder="Выберите теги"
                                    x-data
                                    x-init="
                                        $($el).select2({
                                            placeholder: 'Выберите теги'
                                        });
                                        $($el).on('change', function (e) {
                                            @this.set('tags_selected', $($el).val());
                                        });
                                    ">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                            @if(in_array($tag->id, $tags_selected)) selected @endif>
                                            {{ $tag->tr('name') }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Выберите теги из списка</small>
                            </div>
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
                                    class="btn btn-primary btn-block waves-effect waves-light"
                                    wire:loading.attr="disabled"
                                    wire:target="newImages">
                                <i class="bx bx-save font-size-16 align-middle mr-1"></i>
                                <span wire:loading.remove wire:target="newImages">Сохранить и закрыть</span>
                                <span wire:loading wire:target="newImages">
                                    <i class="bx bx-loader bx-spin"></i> Загрузка изображений...
                                </span>
                            </button>
                            <button type="button"
                                    wire:click.prevent="save"
                                    class="btn btn-success btn-block waves-effect waves-light mt-2"
                                    wire:loading.attr="disabled"
                                    wire:target="newImages">
                                <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                <span wire:loading.remove wire:target="newImages">Сохранить</span>
                                <span wire:loading wire:target="newImages">
                                    <i class="bx bx-loader bx-spin"></i> Загрузка изображений...
                                </span>
                            </button>
                            <a href="{{ route('admin.tours.index') }}"
                                class="btn btn-secondary btn-block waves-effect waves-light mt-2"
                                wire:loading.attr="disabled"
                                wire:target="newImages">
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
    <script>
        document.addEventListener('livewire:initialized', () => {
             // Optional: init globally if needed, but x-init handles per-element
        });
    </script>
@endpush

@push('quill-css')
    <link href="{{ asset('vendor/livewire-quill/quill.snow.min.css') }}" rel="stylesheet">
@endpush

@push('quill-js')
    <script src="{{ asset('vendor/livewire-quill/quill.js') }}"></script>
@endpush

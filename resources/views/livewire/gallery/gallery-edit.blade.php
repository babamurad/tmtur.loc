{{-- resources/views/livewire/gallery/gallery-edit-component.blade.php --}}
<div class="page-content">
    <div class="container-fluid">

        {{-- Хлебные крошки --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Редактировать фото</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Галерея</a></li>
                        <li class="breadcrumb-item active">Редактирование</li>
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
                                Информация о фото
                            </h5>

                            {{-- Language Tabs --}}
                            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" 
                                       data-toggle="tab" 
                                       href="#lang-{{ config('app.fallback_locale') }}" 
                                       role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">{{ strtoupper(config('app.fallback_locale')) }}</span>
                                    </a>
                                </li>
                                @foreach(config('app.available_locales') as $locale)
                                    @continue($locale === config('app.fallback_locale'))
                                    <li class="nav-item">
                                        <a class="nav-link" 
                                           data-toggle="tab" 
                                           href="#lang-{{ $locale }}" 
                                           role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">{{ strtoupper($locale) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Tab Content --}}
                            <div class="tab-content">
                                {{-- Default Language Tab --}}
                                <div class="tab-pane active" 
                                     id="lang-{{ config('app.fallback_locale') }}" 
                                     role="tabpanel">
                                    
                                    <!-- Title -->
                                    <div class="form-group">
                                        <label>Название <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('title') is-invalid @enderror"
                                               wire:model.defer="title"
                                               placeholder="Введите название">
                                        @error('title') 
                                            <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label>Описание</label>
                                        <x-quill wire:model.defer="trans.{{ config('app.fallback_locale') }}.description" />
                                        @error('trans.'.config('app.fallback_locale').'.description')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Location -->
                                    <div class="form-group">
                                        <label>Местоположение</label>
                                        <input type="text" 
                                               class="form-control @error('trans.'.config('app.fallback_locale').'.location') is-invalid @enderror"
                                               wire:model.defer="trans.{{ config('app.fallback_locale') }}.location"
                                               placeholder="Например: Ашхабад">
                                        @error('trans.'.config('app.fallback_locale').'.location') 
                                            <div class="invalid-feedback">{{ $message }}</div> 
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <!-- Photographer -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Фотограф</label>
                                                <input type="text" 
                                                       class="form-control @error('trans.'.config('app.fallback_locale').'.photographer') is-invalid @enderror"
                                                       wire:model.defer="trans.{{ config('app.fallback_locale') }}.photographer"
                                                       placeholder="Имя фотографа">
                                                @error('trans.'.config('app.fallback_locale').'.photographer') 
                                                    <div class="invalid-feedback">{{ $message }}</div> 
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Alt Text -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Alt-текст</label>
                                                <input type="text" 
                                                       class="form-control @error('trans.'.config('app.fallback_locale').'.alt_text') is-invalid @enderror"
                                                       wire:model.defer="trans.{{ config('app.fallback_locale') }}.alt_text"
                                                       placeholder="Описание для SEO">
                                                @error('trans.'.config('app.fallback_locale').'.alt_text') 
                                                    <div class="invalid-feedback">{{ $message }}</div> 
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Other Language Tabs --}}
                                @foreach(config('app.available_locales') as $locale)
                                    @continue($locale === config('app.fallback_locale'))
                                    <div class="tab-pane" 
                                         id="lang-{{ $locale }}" 
                                         role="tabpanel">
                                        
                                        <!-- Title -->
                                        <div class="form-group">
                                            <label>Название</label>
                                            <input type="text" 
                                                   class="form-control @error('trans.'.$locale.'.title') is-invalid @enderror"
                                                   wire:model.defer="trans.{{ $locale }}.title"
                                                   placeholder="Название на {{ strtoupper($locale) }}">
                                            @error('trans.'.$locale.'.title') 
                                                <div class="invalid-feedback">{{ $message }}</div> 
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="form-group">
                                            <label>Описание</label>
                                            <x-quill wire:model.defer="trans.{{ $locale }}.description" />
                                            @error('trans.'.$locale.'.description')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Location -->
                                        <div class="form-group">
                                            <label>Местоположение</label>
                                            <input type="text" 
                                                   class="form-control @error('trans.'.$locale.'.location') is-invalid @enderror"
                                                   wire:model.defer="trans.{{ $locale }}.location"
                                                   placeholder="Например: Ашхабад">
                                            @error('trans.'.$locale.'.location') 
                                                <div class="invalid-feedback">{{ $message }}</div> 
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <!-- Photographer -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Фотограф</label>
                                                    <input type="text" 
                                                           class="form-control @error('trans.'.$locale.'.photographer') is-invalid @enderror"
                                                           wire:model.defer="trans.{{ $locale }}.photographer"
                                                           placeholder="Имя фотографа">
                                                    @error('trans.'.$locale.'.photographer') 
                                                        <div class="invalid-feedback">{{ $message }}</div> 
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Alt Text -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Alt-текст</label>
                                                    <input type="text" 
                                                           class="form-control @error('trans.'.$locale.'.alt_text') is-invalid @enderror"
                                                           wire:model.defer="trans.{{ $locale }}.alt_text"
                                                           placeholder="Описание для SEO">
                                                    @error('trans.'.$locale.'.alt_text') 
                                                        <div class="invalid-feedback">{{ $message }}</div> 
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Column --}}
                <div class="col-lg-4">
                    {{-- Image Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-image font-size-18 align-middle mr-1 text-primary"></i>
                                Изображение
                            </h5>
                            
                            <div class="form-group">
                                <label>Заменить файл</label>
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input @error('newPhoto') is-invalid @enderror"
                                           id="newPhoto"
                                           wire:model="newPhoto"
                                           accept="image/*">
                                    <label class="custom-file-label" for="newPhoto">
                                        {{ $newPhoto ? $newPhoto->getClientOriginalName() : 'Выберите файл' }}
                                    </label>
                                    @error('newPhoto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Превью нового файла --}}
                            @if($newPhoto)
                                <div class="mt-3">
                                    <p class="text-muted mb-2"><small>Новое изображение:</small></p>
                                    <img src="{{ $newPhoto->temporaryUrl() }}"
                                         class="img-fluid rounded shadow-sm"
                                         style="max-height:200px;object-fit:cover;" alt="Новое">
                                </div>
                            @endif

                            {{-- Текущее изображение --}}
                            @if($photo->file_path)
                                <div class="mt-3">
                                    <p class="text-muted mb-2"><small>Текущее изображение:</small></p>
                                    <img src="{{ asset('uploads/'.$photo->file_path) }}"
                                         class="img-fluid rounded shadow-sm"
                                         style="max-height:200px;object-fit:cover;" alt="Текущее">
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

                            <!-- Order -->
                            <div class="form-group">
                                <label>Порядок</label>
                                <input type="number" 
                                       wire:model.defer="order"
                                       class="form-control @error('order') is-invalid @enderror" 
                                       min="0">
                                @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Featured -->
                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" 
                                           class="custom-control-input" 
                                           id="is_featured"
                                           wire:model.defer="is_featured">
                                    <label class="custom-control-label" for="is_featured">
                                        <strong>Избранное</strong>
                                        <br>
                                        <small class="text-muted">Показывать в избранном</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="card">
                        <div class="card-body">
                            <button type="submit"
                                    class="btn btn-success btn-block waves-effect waves-light">
                                <i class="fas fa-save font-size-16 align-middle mr-1"></i>
                                Сохранить
                            </button>
                            <a href="{{ route('gallery.index') }}"
                               class="btn btn-secondary btn-block waves-effect waves-light mt-2">
                                <i class="fas fa-times font-size-16 align-middle mr-1"></i>
                                Отмена
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

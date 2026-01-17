{{-- resources/views/livewire/gallery/gallery-create-component.blade.php --}}
<div class="page-content">
    <div class="container-fluid">

        {{-- Заголовок + хлебные крошки --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Добавить фото в галерею</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Галерея</a></li>
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
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">
                                    <i class="bx bx-edit-alt font-size-18 align-middle mr-1 text-primary"></i>
                                    Информация о фото
                                </h5>
                                <div class="d-flex align-items-center">
                                    @if($translationDuration)
                                        <span class="text-success mr-3 font-size-12">
                                            <i class="bx bx-time-five"></i> {{ $translationDuration }} сек.
                                        </span>
                                    @endif

                                    <button type="button" class="btn btn-sm btn-info waves-effect waves-light"
                                        wire:click="translateToAllLanguages" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="translateToAllLanguages">
                                            <i class="bx bx-world font-size-16 align-middle mr-1"></i> Перевести всё
                                        </span>
                                        <span wire:loading wire:target="translateToAllLanguages">
                                            <i class="bx bx-loader bx-spin font-size-16 align-middle mr-1"></i>
                                            Перевод...
                                        </span>
                                    </button>
                                </div>
                            </div>

                            {{-- Language Tabs --}}
                            @php
                                $locales = config('app.available_locales');
                                if (($key = array_search('ru', $locales)) !== false) {
                                    unset($locales[$key]);
                                    array_unshift($locales, 'ru');
                                }
                            @endphp

                            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                @foreach($locales as $locale)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $locale === 'ru' ? 'active' : '' }}" data-toggle="tab"
                                            href="#lang-{{ $locale }}" role="tab">
                                            <span class="d-block d-sm-none">
                                                @if($locale === 'ru') <i class="fas fa-home"></i>
                                                @else <i class="far fa-user"></i> @endif
                                            </span>
                                            <span class="d-none d-sm-block">{{ strtoupper($locale) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Tab Content --}}
                            <div class="tab-content">
                                @foreach($locales as $locale)
                                    @php
                                        $isFallback = $locale === config('app.fallback_locale');
                                    @endphp
                                    <div class="tab-pane {{ $locale === 'ru' ? 'active' : '' }}" id="lang-{{ $locale }}"
                                        role="tabpanel">

                                        <!-- Title -->
                                        <div class="form-group">
                                            <label>Название @if($isFallback) <span class="text-danger">*</span>
                                            @endif</label>
                                            <input type="text"
                                                class="form-control @error($isFallback ? 'title' : 'trans.' . $locale . '.title') is-invalid @enderror"
                                                wire:model.defer="{{ $isFallback ? 'title' : 'trans.' . $locale . '.title' }}"
                                                placeholder="Название на {{ strtoupper($locale) }}">
                                            @error($isFallback ? 'title' : 'trans.' . $locale . '.title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="form-group">
                                            <label>Описание</label>
                                            <x-quill wire:model.defer="trans.{{ $locale }}.description" />
                                            @error('trans.' . $locale . '.description')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Location -->
                                        <div class="form-group">
                                            <label>Местоположение</label>
                                            <input type="text"
                                                class="form-control @error('trans.' . $locale . '.location') is-invalid @enderror"
                                                wire:model.defer="trans.{{ $locale }}.location"
                                                placeholder="Например: Ашхабад">
                                            @error('trans.' . $locale . '.location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <!-- Photographer -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Фотограф</label>
                                                    <input type="text"
                                                        class="form-control @error('trans.' . $locale . '.photographer') is-invalid @enderror"
                                                        wire:model.defer="trans.{{ $locale }}.photographer"
                                                        placeholder="Имя фотографа">
                                                    @error('trans.' . $locale . '.photographer')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Alt Text -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Alt-текст</label>
                                                    <input type="text"
                                                        class="form-control @error('trans.' . $locale . '.alt_text') is-invalid @enderror"
                                                        wire:model.defer="trans.{{ $locale }}.alt_text"
                                                        placeholder="Описание для SEO">
                                                    @error('trans.' . $locale . '.alt_text')
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
                                <label>Файл <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('photo') is-invalid @enderror"
                                        id="photo" wire:model="photo" accept="image/*">
                                    <label class="custom-file-label" for="photo">
                                        {{ $photo ? $photo->getClientOriginalName() : 'Выберите файл' }}
                                    </label>
                                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Превью --}}
                            @if($photo)
                                <div class="mt-3">
                                    <p class="text-muted mb-2"><small>Предпросмотр:</small></p>
                                    <img src="{{ $photo->temporaryUrl() }}" class="img-fluid rounded shadow-sm"
                                        style="max-height:200px;object-fit:cover;" alt="Превью">
                                </div>
                            @else
                                <div class="mt-3 text-center p-4 bg-light rounded">
                                    <i class="bx bx-image-add font-size-48 text-muted"></i>
                                    <p class="text-muted mb-0 mt-2">Изображение не выбрано</p>
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
                                <input type="number" wire:model.defer="order"
                                    class="form-control @error('order') is-invalid @enderror" min="0">
                                @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Featured -->
                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_featured"
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
                            <button type="submit" class="btn btn-success btn-block waves-effect waves-light">
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


    </div>
    </form>
</div>
</div>
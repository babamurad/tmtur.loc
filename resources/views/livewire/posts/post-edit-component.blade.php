<div class="page-content">
    <div class="container-fluid">
        <!-- page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Редактировать пост</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Посты</a></li>
                        <li class="breadcrumb-item active">Редактировать</li>
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
                                    Контент поста
                                </h5>
                                <div class="d-flex align-items-center">
                                    @if($translationDuration)
                                        <span class="text-success mr-3 font-size-12">
                                            <i class="bx bx-time-five"></i> {{ $translationDuration }} сек.
                                        </span>
                                    @endif

                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            wire:click="autoTranslateToEnglish" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="autoTranslateToEnglish">
                                                <i class="bx bx-globe font-size-16 align-middle mr-1"></i> En
                                            </span>
                                            <span wire:loading wire:target="autoTranslateToEnglish">
                                                <i class="bx bx-loader bx-spin font-size-16 align-middle mr-1"></i> En
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-info waves-effect waves-light"
                                            wire:click="autoTranslateToKorean" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="autoTranslateToKorean">
                                                <i class="bx bx-globe font-size-16 align-middle mr-1"></i> Ko
                                            </span>
                                            <span wire:loading wire:target="autoTranslateToKorean">
                                                <i class="bx bx-loader bx-spin font-size-16 align-middle mr-1"></i> Ko
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-warning waves-effect waves-light"
                                            wire:click="translateToAllLanguages" wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="translateToAllLanguages">
                                                <i class="bx bx-world font-size-16 align-middle mr-1"></i> All
                                            </span>
                                            <span wire:loading wire:target="translateToAllLanguages">
                                                <i class="bx bx-loader bx-spin font-size-16 align-middle mr-1"></i> All
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Language Tabs --}}
                            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                @foreach(config('app.available_locales') as $index => $locale)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}" data-toggle="tab"
                                            href="#lang-{{ $locale }}" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">{{ strtoupper($locale) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Tab Content --}}
                            <div class="tab-content">
                                @foreach(config('app.available_locales') as $index => $locale)
                                    <div class="tab-pane {{ $index === 0 ? 'active' : '' }}" id="lang-{{ $locale }}"
                                        role="tabpanel" wire:key="lang-tab-{{ $locale }}">

                                        <!-- Title -->
                                        <div class="form-group">
                                            <label>Заголовок ({{ strtoupper($locale) }})
                                                @if($locale === config('app.fallback_locale'))
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="text"
                                                class="form-control @error('trans.' . $locale . '.title') is-invalid @enderror"
                                                wire:model.debounce.500ms="trans.{{ $locale }}.title"
                                                placeholder="Введите заголовок">
                                            @error('trans.' . $locale . '.title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if($locale === config('app.fallback_locale'))
                                                <small class="form-text text-muted">Slug: {{ $slug }}</small>
                                            @endif
                                        </div>

                                        <!-- Content -->
                                        <div class="form-group">
                                            <label>Контент ({{ strtoupper($locale) }})</label>
                                            <x-quill wire:model="trans.{{ $locale }}.content" />
                                            @error('trans.' . $locale . '.content')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Column --}}
                <div class="col-lg-4">
                    {{-- Category & Settings Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-cog font-size-18 align-middle mr-1 text-primary"></i>
                                Настройки
                            </h5>

                            <!-- category -->
                            <div class="form-group">
                                <label>Категория <span class="text-danger">*</span></label>
                                <select class="form-control @error('category_id') is-invalid @enderror"
                                    wire:model.defer="category_id">
                                    <option value="0">-- Выберите категорию --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- status -->
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="status"
                                        wire:model.defer="status">
                                    <label class="custom-control-label" for="status">
                                        <strong>Опубликовано</strong>
                                        <br>
                                        <small class="text-muted">Показывать пост на сайте</small>
                                    </label>
                                </div>
                            </div>

                            <!-- published_at -->
                            <div class="form-group mb-0">
                                <label>Дата публикации</label>
                                <input type="datetime-local"
                                    class="form-control @error('published_at') is-invalid @enderror"
                                    wire:model.defer="published_at">
                                @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Image Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-image font-size-18 align-middle mr-1 text-primary"></i>
                                Изображение
                            </h5>

                            <div class="form-group">
                                <label>Новое изображение</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('newImage') is-invalid @enderror"
                                        id="newImage" wire:model="newImage" accept="image/*">
                                    <label class="custom-file-label" for="newImage">
                                        {{ $newImage ? $newImage->getClientOriginalName() : 'Выберите файл' }}
                                    </label>
                                    @error('newImage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- progress -->
                            <div class="mt-2 d-none" wire:loading wire:target="newImage"
                                wire:loading.class.remove="d-none">
                                <div class="progress" style="height:20px;">
                                    <div class="progress-bar" role="progressbar" style="width:{{ $uploadProgress }}%"
                                        aria-valuenow="{{ $uploadProgress }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $uploadProgress }}%
                                    </div>
                                </div>
                            </div>

                            <!-- preview -->
                            @if($newImage)
                                <div class="mt-3">
                                    <p class="text-muted mb-2"><small>Новое изображение:</small></p>
                                    <img src="{{ $newImage->temporaryUrl() }}" class="img-fluid rounded shadow-sm"
                                        alt="New Preview">
                                </div>
                            @endif

                            @if($currentImage)
                                <div class="mt-3">
                                    <p class="text-muted mb-2"><small>Текущее изображение:</small></p>
                                    <img src="{{ asset('uploads/' . $currentImage) }}" class="img-fluid rounded shadow-sm"
                                        alt="Current Image">
                                </div>
                            @endif

                            @if(!$newImage && !$currentImage)
                                <div class="mt-3 text-center p-4 bg-light rounded">
                                    <i class="bx bx-image-add font-size-48 text-muted"></i>
                                    <p class="text-muted mb-0 mt-2">Изображение не выбрано</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success btn-block waves-effect waves-light"
                                wire:loading.attr="disabled" wire:target="save">
                                <span wire:loading.remove wire:target="save">
                                    <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                    Сохранить
                                </span>
                                <span wire:loading wire:target="save">
                                    <i class="bx bx-loader bx-spin font-size-16 align-middle mr-1"></i>
                                    Сохраняем...
                                </span>
                            </button>
                            <a href="{{ route('posts.index') }}"
                                class="btn btn-secondary btn-block waves-effect waves-light mt-2">
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
<div class="page-content">
    <div class="container-fluid">

        <!-- page-title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Создать пост</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Посты</a></li>
                        <li class="breadcrumb-item active">Создать</li>
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
                                Контент поста
                            </h5>

                            {{-- Language Tabs --}}
                            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                @foreach(config('app.available_locales') as $index => $locale)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                           data-toggle="tab" 
                                           href="#lang-{{ $locale }}" 
                                           role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">{{ strtoupper($locale) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Tab Content --}}
                            <div class="tab-content">
                                @foreach(config('app.available_locales') as $index => $locale)
                                    <div class="tab-pane {{ $index === 0 ? 'active' : '' }}" 
                                         id="lang-{{ $locale }}" 
                                         role="tabpanel"
                                         wire:key="lang-tab-{{ $locale }}">
                                        
                                        <!-- Title -->
                                        <div class="form-group">
                                            <label>Заголовок ({{ strtoupper($locale) }}) 
                                                @if($locale === config('app.fallback_locale'))
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('trans.'.$locale.'.title') is-invalid @enderror"
                                                   wire:model.debounce.300ms="trans.{{ $locale }}.title"
                                                   placeholder="Введите заголовок">
                                            @error('trans.'.$locale.'.title') 
                                                <div class="invalid-feedback">{{ $message }}</div> 
                                            @enderror
                                            @if($locale === config('app.fallback_locale'))
                                                <small class="form-text text-muted">Slug: {{ $slug }}</small>
                                            @endif
                                        </div>

                                        <!-- Content -->
                                        <div class="form-group">
                                            <label>Контент ({{ strtoupper($locale) }})</label>
                                            <x-quill wire:model.defer="trans.{{ $locale }}.content" />
                                            @error('trans.'.$locale.'.content')
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
                                        <strong>Опубликовать сразу</strong>
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

                            <!-- прогресс -->
                            <div class="mt-2 d-none" wire:loading wire:target="image" wire:loading.class.remove="d-none">
                                <div class="progress" style="height:20px;">
                                    <div class="progress-bar" role="progressbar"
                                         style="width:{{ $uploadProgress }}%"
                                         aria-valuenow="{{ $uploadProgress }}"
                                         aria-valuemin="0" aria-valuemax="100">
                                        {{ $uploadProgress }}%
                                    </div>
                                </div>
                            </div>

                            <!-- preview -->
                            @if($image)
                                <div class="mt-3">
                                    <p class="text-muted mb-2"><small>Предпросмотр:</small></p>
                                    <img src="{{ $image->temporaryUrl() }}"
                                         class="img-fluid rounded shadow-sm" alt="Preview">
                                </div>
                            @else
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
                            <button type="submit"
                                    class="btn btn-success btn-block waves-effect waves-light">
                                <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                Сохранить
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



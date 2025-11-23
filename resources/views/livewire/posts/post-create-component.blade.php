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

        <!-- форма -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Основные данные</h5>

                        <form wire:submit.prevent="save">
                            @csrf

                            <!-- Мультиязычные поля -->
                            <div class="form-group">
                                <label>Переводы <span class="text-danger">*</span></label>
                                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                    @foreach(config('app.available_locales') as $index => $locale)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                               data-toggle="tab" 
                                               href="#lang-{{ $locale }}" 
                                               role="tab">
                                                {{ strtoupper($locale) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content p-3 border border-top-0">
                                    @foreach(config('app.available_locales') as $index => $locale)
                                        <div class="tab-pane {{ $index === 0 ? 'active' : '' }}" 
                                             id="lang-{{ $locale }}" 
                                             role="tabpanel">
                                            
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
                                                       @if($locale === config('app.fallback_locale'))
                                                           wire:model.debounce.300ms="title"
                                                       @endif
                                                       placeholder="Введите заголовок">
                                                @error('trans.'.$locale.'.title') 
                                                    <div class="invalid-feedback">{{ $message }}</div> 
                                                @enderror
                                            </div>

                                            <!-- Content -->
                                            <div class="form-group" wire:ignore>
                                                <label>Контент ({{ strtoupper($locale) }})</label>
                                                <div id="quill-editor-{{ $locale }}" style="height: 200px;"></div>
                                                @error('trans.'.$locale.'.content')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- slug -->
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       wire:model="slug"
                                       disabled
                                       placeholder="Оставьте пустым для автогенерации">
                                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

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
                                    <label class="custom-control-label" for="status">Опубликовать сразу</label>
                                </div>
                            </div>

                            <!-- published_at -->
                            <div class="form-group">
                                <label>Дата публикации</label>
                                <input type="datetime-local"
                                       class="form-control @error('published_at') is-invalid @enderror"
                                       wire:model.defer="published_at">
                                @error('published_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- image -->
                            <div class="form-group">
                                <label>Изображение</label>
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
                                <div class="position-relative mt-2" style="height:150px;">
                                    <div wire:loading.remove wire:target="image">
                                        @if($image)
                                            <img src="{{ $image->temporaryUrl() }}"
                                                 class="img-fluid rounded" style="max-height:150px;">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- buttons -->
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                    Сохранить
                                </button>
                                <a href="{{ route('posts.index') }}"
                                   class="btn btn-secondary waves-effect waves-light">
                                    <i class="bx bx-x font-size-16 align-middle mr-1"></i>
                                    Отмена
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Quill CSS --}}
@push('quill-css')
    <link href="{{ asset('vendor/livewire-quill/quill.snow.min.css') }}" rel="stylesheet">
@endpush

{{-- Quill JS + инициализация --}}
@push('quill-js')
    <script src="{{ asset('vendor/livewire-quill/quill.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const locales = @json(config('app.available_locales'));
            const editors = {};

            locales.forEach(locale => {
                const editor = new Quill(`#quill-editor-${locale}`, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'font': [] }, { 'size': [] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'script': 'sub'}, { 'script': 'super' }],
                            [{ 'header': 1 }, { 'header': 2 }],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            [{ 'indent': '-1' }, { 'indent': '+1' }],
                            [{ 'align': [] }],
                            ['link', 'image', 'video'],
                            ['clean']
                        ]
                    }
                });

                // Начальное значение из модели
                const initialContent = @this.get(`trans.${locale}.content`) || '';
                editor.root.innerHTML = initialContent;

                // Синхронизация с Livewire
                editor.on('text-change', () => {
                    @this.set(`trans.${locale}.content`, editor.root.innerHTML);
                });

                editors[locale] = editor;
            });
        });
    </script>
@endpush


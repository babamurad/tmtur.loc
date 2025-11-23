<div class="page-content">
    <div class="container-fluid">

        <!-- page-title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Создать категорию</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Категории</a></li>
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

                            <!-- Tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach(config('app.available_locales') as $locale)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                           data-toggle="tab"
                                           href="#tab-{{ $locale }}"
                                           role="tab">
                                            {{ strtoupper($locale) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content mt-3 mb-3">
                                @foreach(config('app.available_locales') as $locale)
                                    <div class="tab-pane {{ $loop->first ? 'active' : '' }}"
                                         id="tab-{{ $locale }}"
                                         role="tabpanel">

                                        @if($locale === config('app.fallback_locale'))
                                            <!-- title (main) -->
                                            <div class="form-group">
                                                <label>Название ({{ strtoupper($locale) }}) <span class="text-danger">*</span></label>
                                                <input type="text"
                                                       class="form-control @error('title') is-invalid @enderror"
                                                       wire:model.live="title"
                                                       placeholder="Например: Городские туры">
                                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <!-- content (main) -->
                                            <div class="form-group">
                                                <label>Описание ({{ strtoupper($locale) }})</label>
                                                <textarea rows="4"
                                                          class="form-control @error('content') is-invalid @enderror"
                                                          wire:model="content"></textarea>
                                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        @else
                                            <!-- title (trans) -->
                                            <div class="form-group">
                                                <label>Название ({{ strtoupper($locale) }})</label>
                                                <input type="text"
                                                       class="form-control"
                                                       wire:model="trans.{{ $locale }}.title">
                                            </div>

                                            <!-- content (trans) -->
                                            <div class="form-group">
                                                <label>Описание ({{ strtoupper($locale) }})</label>
                                                <textarea rows="4"
                                                          class="form-control"
                                                          wire:model="trans.{{ $locale }}.content"></textarea>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- slug -->
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       readonly
                                       wire:model="slug"
                                       disabled
                                       placeholder="auto-generate если пусто">
                                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

                                <!-- preview -->
                                <div class="mt-3 d-none mx-auto text-center" wire:loading wire:target="image" wire:loading.class="d-block">
                                    <span class="spinner-border spinner-border-sm text-primary"></span>
                                    <small class="text-muted">Загружаю изображение...</small>
                                </div>

                                {{-- превью --}}
                                <div class="mt-3" style="height:200px;">
                                    @if ($image)
                                        <img class="img-fluid rounded"
                                             style="max-height:200px; object-fit:cover;"
                                             src="{{ $image->temporaryUrl() }}" alt="preview">
                                    @else
                                        <img class="img-fluid rounded"
                                             style="max-height:200px; object-fit:cover;"
                                             src="{{ asset('assets/images/media/sm-5.jpg') }}" alt="placeholder">
                                    @endif
                                </div>
                            </div>

                            <!-- is_published -->
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           id="is_published"
                                           wire:model="is_published">
                                    <label class="custom-control-label" for="is_published">Опубликовано</label>
                                </div>
                            </div>

                            <!-- buttons -->
                            <div class="form-group mb-0">
                                <button type="submit"
                                        class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                    Сохранить
                                </button>
                                <a href="{{ route('categories.index') }}"
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

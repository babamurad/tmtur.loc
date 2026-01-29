<div class="page-content">
    <div class="container-fluid">

        <!-- page-title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Редактировать категорию</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Категории</a></li>
                        <li class="breadcrumb-item active">Редактировать</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- форма -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Основные данные</h5>
                            <x-gemini-translation-buttons :duration="$translationDuration" />
                        </div>

                        <form wire:submit.prevent="save">

                            <!-- Tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach(config('app.available_locales') as $locale)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab"
                                            href="#tab-{{ $locale }}" role="tab">
                                            {{ strtoupper($locale) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content mt-3 mb-3">
                                @foreach(config('app.available_locales') as $locale)
                                    <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="tab-{{ $locale }}"
                                        role="tabpanel">

                                        @if($locale === config('app.fallback_locale'))
                                            <!-- title (main) -->
                                            <div class="form-group">
                                                <label>Название ({{ strtoupper($locale) }}) <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                    wire:model.live="title">
                                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <!-- content (main) -->
                                            <div class="form-group">
                                                <label>Описание ({{ strtoupper($locale) }})</label>
                                                <textarea rows="4" class="form-control @error('content') is-invalid @enderror"
                                                    wire:model="content"></textarea>
                                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        @else
                                            <!-- title (trans) -->
                                            <div class="form-group">
                                                <label>Название ({{ strtoupper($locale) }})</label>
                                                <input type="text" class="form-control" wire:model="trans.{{ $locale }}.title">
                                            </div>

                                            <!-- content (trans) -->
                                            <div class="form-group">
                                                <label>Описание ({{ strtoupper($locale) }})</label>
                                                <textarea rows="4" class="form-control"
                                                    wire:model="trans.{{ $locale }}.content"></textarea>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- slug -->
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" disabled
                                    wire:model="slug">
                                @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- newImage -->
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

                                <!-- preview -->
                                <div class="position-relative mt-2" style="height:200px;">
                                    <!-- <div wire:loading wire:target="newImage"
                                         class="spinner-border text-primary m-2 top-50 start-50">
                                        <span class="sr-only"></span>
                                    </div> -->
                                    <div wire:loading.remove wire:target="newImage">
                                        @if ($newImage)
                                            <img class="img-fluid rounded" style="max-height:200px; object-fit:cover;"
                                                src="{{ $newImage->temporaryUrl() }}" alt="preview">
                                        @else
                                            <img class="img-fluid rounded" style="max-height:200px; object-fit:cover;"
                                                src="{{ $category->image_url }}" alt="current">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- is_published -->
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_published"
                                        wire:model="is_published">
                                    <label class="custom-control-label" for="is_published">Опубликовано</label>
                                </div>
                            </div>

                            <!-- buttons -->
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-2">
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
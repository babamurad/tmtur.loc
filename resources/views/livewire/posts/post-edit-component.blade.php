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

        <!-- form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Основные данные</h5>

                        <form wire:submit.prevent="save">
                            @csrf

                            <!-- title -->
                            <div class="form-group">
                                <label>Заголовок <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       wire:model.debounce.500ms="title">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- slug -->
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       wire:model.defer="slug">
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

                            <!-- content -->
                            <div class="form-group">
                                <label>Содержание</label>
                                <textarea rows="6"
                                          class="form-control @error('content') is-invalid @enderror"
                                          wire:model.defer="content"></textarea>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- status -->
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="status"
                                           wire:model.defer="status">
                                    <label class="custom-control-label" for="status">Опубликовано</label>
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

                            <!-- newImage -->
                            <div class="form-group">
                                <label>Новое изображение</label>
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input @error('newImage') is-invalid @enderror"
                                           id="newImage"
                                           wire:model="newImage"
                                           accept="image/*">
                                    <label class="custom-file-label" for="newImage">
                                        {{ $newImage ? $newImage->getClientOriginalName() : 'Выберите файл' }}
                                    </label>
                                    @error('newImage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <!-- progress -->
                                <div class="mt-2 d-none" wire:loading wire:target="newImage" wire:loading.class.remove="d-none">
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
                                <div class="position-relative mb-5" style="height:150px;">
                                    <div class="row mb-2">
                                        @if($currentImage)
                                            <div wire:loading.remove wire:target="newImage" class="img-fluid rounded mr-1" style="max-height:150px;">
                                                <small class="text-muted">Текущее изображение</small><br>
                                                <img src="{{ asset('uploads/' . $currentImage) }}"
                                                     class="img-fluid rounded" style="max-height:150px;">
                                            </div>
                                        @endif
                                        @if($newImage)
                                            <div>
                                                <small class="text-muted">Новое изображение:</small><br>
                                                <img src="{{ $newImage->temporaryUrl() }}"
                                                     class="img-fluid rounded ml-1" style="max-height:150px;">
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <!-- buttons -->
                            <div class="form-group mb-0 pt-1">
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

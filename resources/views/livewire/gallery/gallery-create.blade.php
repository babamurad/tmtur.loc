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

        {{-- Форма --}}
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Информация о фото</h5>

                        <form wire:submit.prevent="save">
                            <div class="row">
                                {{-- Название --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Название <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="title"
                                               class="form-control @error('title') is-invalid @enderror">
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Описание --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Описание</label>
                                        <textarea wire:model="description"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  rows="3"></textarea>
                                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Местоположение --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Местоположение</label>
                                        <input type="text" wire:model="location"
                                               class="form-control @error('location') is-invalid @enderror">
                                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Фотограф --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Фотограф</label>
                                        <input type="text" wire:model="photographer"
                                               class="form-control @error('photographer') is-invalid @enderror">
                                        @error('photographer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Alt-текст --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Alt-текст</label>
                                        <input type="text" wire:model="alt_text"
                                               class="form-control @error('alt_text') is-invalid @enderror">
                                        @error('alt_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Порядок --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Порядок</label>
                                        <input type="number" wire:model="order"
                                               class="form-control @error('order') is-invalid @enderror" min="0">
                                        @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Избранное --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="d-block">&nbsp;</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_featured"
                                                   wire:model="is_featured">
                                            <label class="custom-control-label" for="is_featured">Избранное</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Кнопки --}}
                            <div class="form-group mb-0 mt-4">
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="fas fa-save font-size-16 align-middle mr-1"></i>Сохранить
                                </button>
                                <a href="{{ route('gallery.index') }}" class="btn btn-secondary waves-effect waves-light">
                                    <i class="fas fa-times font-size-16 align-middle mr-1"></i>Отмена
                                </a>
                            </div>
                        </form>
                    </div>{{-- /.card-body --}}
                </div>{{-- /.card --}}
            </div>{{-- /.col-lg-8 --}}

            {{-- Правая колонка: превью загружаемого файла --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Файл <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input @error('photo') is-invalid @enderror"
                                       id="photo"
                                       wire:model="photo"
                                       accept="image/*">
                                <label class="custom-file-label" for="photo">
                                    {{ $photo ? $photo->getClientOriginalName() : 'Выберите файл' }}
                                </label>
                                @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Превью --}}
                        <div class="position-relative mb-3" style="height:200px;">
                            <div wire:loading.remove wire:target="photo">
                                @if($photo)
                                    <img src="{{ $photo->temporaryUrl() }}"
                                         class="img-fluid rounded"
                                         style="max-height:200px;object-fit:cover;" alt="Preview">
                                @else
                                    <img src="{{ asset('assets/images/media/sm-5.jpg') }}"
                                         class="img-fluid rounded"
                                         style="max-height:200px;object-fit:cover;" alt="Placeholder">
                                @endif
                            </div>
                        </div>
                    </div>{{-- /.card-body --}}
                </div>{{-- /.card --}}
            </div>{{-- /.col-lg-4 --}}
        </div>{{-- /.row --}}
    </div>{{-- /.container-fluid --}}
</div>{{-- /.page-content --}}

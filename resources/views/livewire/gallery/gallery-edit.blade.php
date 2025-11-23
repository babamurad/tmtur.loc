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

        {{-- Форма --}}
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Информация о фото</h5>

                        <form wire:submit.prevent="save">
                            <div class="row">
                                {{-- Title --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Название <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="title"
                                               class="form-control @error('title') is-invalid @enderror">
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Описание</label>
                                        <textarea wire:model="description"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  rows="3"></textarea>
                                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Location --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Местоположение</label>
                                        <input type="text" wire:model="location"
                                               class="form-control @error('location') is-invalid @enderror">
                                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Photographer --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Фотограф</label>
                                        <input type="text" wire:model="photographer"
                                               class="form-control @error('photographer') is-invalid @enderror">
                                        @error('photographer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Alt text --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Alt-текст</label>
                                        <input type="text" wire:model="alt_text"
                                               class="form-control @error('alt_text') is-invalid @enderror">
                                        @error('alt_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Order --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Порядок</label>
                                        <input type="number" wire:model="order" min="0"
                                               class="form-control @error('order') is-invalid @enderror">
                                        @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Featured --}}
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

                            {{-- Buttons --}}
                            <div class="form-group mb-0 mt-4">
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="fas fa-save font-size-16 align-middle mr-1"></i>Сохранить
                                </button>
                                <a href="{{ route('gallery.index') }}" class="btn btn-secondary waves-effect waves-light">
                                    <i class="fas fa-times font-size-16 align-middle mr-1"></i>Отмена
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Правая колонка: файл + превью --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
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

                        {{-- Превью текущего файла --}}
                        <div class="position-relative mb-3" style="height:200px;">
                            <div wire:loading.remove wire:target="newPhoto">
                                @if($newPhoto)
                                    <img src="{{ $newPhoto->temporaryUrl() }}"
                                         class="img-fluid rounded"
                                         style="max-height:200px;object-fit:cover;" alt="Превью">
                                @else
                                    <img src="{{ asset('uploads/'.$photo->file_path) }}"
                                         class="img-fluid rounded"
                                         style="max-height:200px;object-fit:cover;" alt="Текущее">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

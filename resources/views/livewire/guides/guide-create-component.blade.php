<div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Добавить гида</h4>
                        <a href="{{ route('guides.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bx bx-arrow-back"></i> К списку
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form wire:submit.prevent="save">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="name">Имя *</label>
                                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                                                   placeholder="Enter name" wire:model.defer="name">
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <div class="form-group">
                                            <label for="experience_years">Стаж, лет</label>
                                            <input type="number" id="experience_years"
                                                   class="form-control" placeholder="Enter your text" min="0"
                                                   wire:model.defer="experience_years">
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="sort_order">Сортировка</label>
                                        <input type="number" min="0" class="form-control"
                                               id="sort_order"
                                               wire:model.defer="sort_order">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>Специализация</label>
                                    <input type="text" class="form-control"
                                           wire:model.defer="specialization">
                                </div>

                                <div class="mb-3">
                                    <label>Языки *</label>
                                    <div>
                                        @foreach($availableLangs as $code => $label)
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="lang{{ $code }}"
                                                       value="{{ $code }}"
                                                       wire:model="languages">
                                                <label class="custom-control-label"  for="lang{{ $code }}">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('languages') <small class="text-danger">{{ $message }}</small> @enderror


                                </div>

                                <div class="mb-3">
                                    <label>Описание *</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              rows="4" wire:model.defer="description"></textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Image --}}
                                <div class="form-group">
                                    <label for="image">Выберите изображение</label>
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input @error('image') is-invalid @enderror"
                                               id="image"
                                               wire:model="image"
                                               accept="image/*">
                                        <label class="custom-file-label" for="image">
                                            @if ($image)
                                                {{ $image->getClientOriginalName() }}
                                            @else
                                                Выбрать изображение
                                            @endif
                                        </label>
                                        @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- контейнер 200 px --}}
                                <div class="position-relative mb-3" style="height:200px;">

                                    {{-- спиннер во время загрузки --}}
                                    <!-- <div wire:loading wire:target="image" class="spinner-border text-primary m-2 top-50 start-50">
                                                        <span class="sr-only"></span>
                                                    </div> -->

                                    {{-- картинка или плейсхолдер --}}
                                    <div wire:loading.remove wire:target="image">
                                        @if ($image)
                                            {{-- свежезагруженное изображение --}}
                                            <img class="img-fluid rounded"
                                                 style="max-height:200px; object-fit:cover;"
                                                 src="{{ $image->temporaryUrl() }}"
                                                 alt="Preview">
                                        @else
                                            {{-- постоянное изображение, если нужно --}}
                                            <img class="img-fluid rounded"
                                                 style="max-height:200px; object-fit:cover;"
                                                 src="{{ asset('assets/images/media/sm-5.jpg') }}"
                                                 alt="Placeholder">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox"
                                           wire:model="is_active" id="active">
                                    <label class="form-check-label" for="active">
                                        Активен
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-success">
                                    <i class="bx bx-check-double"></i> Сохранить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Редактировать гида</h4>
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
                            <form wire:submit.prevent="update">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Имя *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               wire:model.defer="name">
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Стаж, лет</label>
                                        <input type="number" min="0" class="form-control"
                                               wire:model.defer="experience_years">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Сортировка</label>
                                        <input type="number" min="0" class="form-control"
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
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                       id="lang{{ $code }}"
                                                       value="{{ $code }}"
                                                       wire:model="languages">
                                                <label class="form-check-label" for="lang{{ $code }}">
                                                    {{ $label }}
                                                </label>
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

                                <div class="mb-3">
                                    <label>Фото</label>
                                    <input type="file" class="form-control" wire:model="image">
                                    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                                    @if($guide->image)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($guide->image) }}" width="120" class="img-thumbnail">
                                        </div>
                                    @endif
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

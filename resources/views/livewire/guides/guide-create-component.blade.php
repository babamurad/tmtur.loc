<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Добавить гида</h4>
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

                            {{-- список языков --}}
                            <div class="mb-3">
                                <label>Языки *</label>
                                <div class="row g-2">
                                    @foreach(App\Support\AvailableLanguages::all() as $code => $name)
                                        <div class="col-6 col-md-2">
                                            <label class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                       value="{{ $code }}" wire:model="languages">
                                                <span>{{ $name }}</span>
                                                <a href="#" wire:click.prevent="deleteLanguage('{{ $code }}')"
                                                   class="ms-2 text-danger small"
                                                   onclick="return confirm('Удалить язык?')">×</a>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('languages') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- добавить новый --}}
                            <div class="border-top py-2">
                                <h6>Добавить язык</h6>
                                <div class="row g-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control form-control-sm" placeholder="код (en)"
                                               maxlength="2" wire:model="newCode">
                                        @error('newCode') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control form-control-sm" placeholder="название"
                                               wire:model="newName">
                                        @error('newName') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-sm btn-success w-100" wire:click="addLanguage">+</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Описание *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          rows="4" wire:model.defer="description"></textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Image --}}
                            <div class="form-group mb-3">
                                <label>Фото</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                           wire:model="image" accept="image/*">
                                    <label class="custom-file-label">
                                        {{ $image ? $image->getClientOriginalName() : 'Выбрать изображение' }}
                                    </label>
                                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded mt-2"
                                         style="max-height:200px;">
                                @endif
                            </div>

                            {{-- Active --}}
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox"
                                       wire:model="is_active" id="active">
                                <label class="form-check-label" for="active">Активен</label>
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

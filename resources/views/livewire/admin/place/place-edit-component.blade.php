<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Редактировать место</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.places.index') }}">Места</a></li>
                        <li class="breadcrumb-item active">Редактирование</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Данные места</h5>



                        <form wire:submit.prevent="updatePlace">
                            {{-- Language Tabs --}}
                            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                @foreach(config('app.available_locales') as $index => $locale)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}" data-toggle="tab"
                                            href="#tab-{{ $locale }}" role="tab">
                                            {{ strtoupper($locale) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- AI Translation Buttons --}}
                            <x-gemini-translation-buttons />

                            <div class="tab-content">
                                @foreach(config('app.available_locales') as $index => $locale)
                                    <div class="tab-pane {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $locale }}"
                                        role="tabpanel">

                                        @if($locale === config('app.fallback_locale'))
                                            {{-- Main locale fields --}}
                                            <div class="form-group">
                                                <label class="form-label">Название <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="Введите название места" wire:model="name">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @else
                                            {{-- Translation fields --}}
                                            <div class="form-group">
                                                <label>Название</label>
                                                <input type="text" wire:model.defer="trans.{{ $locale }}.name"
                                                    class="form-control" placeholder="Название на {{ $locale }}">
                                                @error("trans.$locale.name") <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            {{-- Location --}}
                            <div class="form-group">
                                <label class="form-label">Локация <span class="text-danger">*</span></label>
                                <select class="form-control @error('location_id') is-invalid @enderror"
                                    wire:model="location_id">
                                    <option value="">Выберите локацию</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Type --}}
                            <div class="form-group">
                                <label class="form-label">Тип <span class="text-danger">*</span></label>
                                <div>
                                    @foreach($types as $value => $label)
                                        <div class="custom-control custom-radio mb-2">
                                            <input type="radio" id="type-{{ $value }}" name="type"
                                                class="custom-control-input @error('type') is-invalid @enderror"
                                                wire:model="type" value="{{ $value }}">
                                            <label class="custom-control-label" for="type-{{ $value }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @endforeach
                                    @error('type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Cost --}}
                            <div class="form-group">
                                <label class="form-label">Стоимость</label>
                                <input type="text" class="form-control @error('cost') is-invalid @enderror"
                                    placeholder="Введите стоимость" wire:model="cost">
                                @error('cost')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="form-group mb-0 mt-4">
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                    Обновить
                                </button>
                                <a href="{{ route('admin.places.index') }}"
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
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Редактировать услугу</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Услуги</a></li>
                        <li class="breadcrumb-item active">Редактирование</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title mb-0">Детали услуги</h5>
                            <x-gemini-translation-buttons :duration="$translationDuration" />
                        </div>

                        <form wire:submit.prevent="save">
                            {{-- Name --}}
                            <div class="form-group">
                                <label for="name">Название ({{ strtoupper(config('app.fallback_locale')) }}) <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="name" wire:model="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="например, Экскурсия по городу">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @foreach(config('app.available_locales') as $locale)
                                @continue($locale === config('app.fallback_locale'))
                                <div class="form-group">
                                    <label>Название ({{ strtoupper($locale) }})</label>
                                    <input type="text" wire:model="trans.{{ $locale }}.name" class="form-control"
                                        placeholder="Название на {{ $locale }}">
                                    @error("trans.$locale.name") <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            @endforeach

                            {{-- Type --}}
                            <select wire:model="type" class="form-control @error('type') is-invalid @enderror">
                                <option value="">-- Выберите тип --</option>
                                @foreach (App\Enums\ServiceType::options() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Price (cents → рубли) --}}
                            <div class="form-group">
                                <label for="price">Цена по умолчанию, ₽ <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" id="price" wire:model="priceRub"
                                        class="form-control @error('default_price_cents') is-invalid @enderror"
                                        placeholder="1 500.00"
                                        oninput="this.value = this.value.replace(/[^\d,.]/g,'').replace(',','.')">
                                </div>
                                @error('default_price_cents')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                    Сохранить
                                </button>
                                <a href="{{ route('services.index') }}"
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
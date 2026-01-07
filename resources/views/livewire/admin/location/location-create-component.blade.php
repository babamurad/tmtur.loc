<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Добавить новую локацию</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.locations.index') }}">Локации</a></li>
                        <li class="breadcrumb-item active">Создание</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Данные локации</h5>

                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                        @endif

                        <form wire:submit.prevent="storeLocation">
                            {{-- Language Tabs --}}
                            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                @foreach(config('app.available_locales') as $index => $locale)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                           data-toggle="tab" 
                                           href="#tab-{{ $locale }}" 
                                           role="tab">
                                            {{ strtoupper($locale) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content">
                                @foreach(config('app.available_locales') as $index => $locale)
                                    <div class="tab-pane {{ $index === 0 ? 'active' : '' }}" 
                                         id="tab-{{ $locale }}" 
                                         role="tabpanel">
                                        
                                        @if($locale === config('app.fallback_locale'))
                                            {{-- Main locale fields --}}
                                            <div class="form-group">
                                                <label class="form-label">Название <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                       class="form-control @error('name') is-invalid @enderror" 
                                                       placeholder="Введите название локации" 
                                                       wire:model="name">
                                                @error('name') 
                                                    <div class="invalid-feedback">{{ $message }}</div> 
                                                @enderror
                                                <small class="text-muted">Slug будет сгенерирован автоматически</small>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Описание</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                                          placeholder="Введите описание локации" 
                                                          wire:model="description"
                                                          rows="4"></textarea>
                                                @error('description') 
                                                    <div class="invalid-feedback">{{ $message }}</div> 
                                                @enderror
                                            </div>
                                        @else
                                            {{-- Translation fields --}}
                                            <div class="form-group">
                                                <label>Название</label>
                                                <input type="text"
                                                       wire:model.defer="trans.{{ $locale }}.name"
                                                       class="form-control"
                                                       placeholder="Название на {{ $locale }}">
                                                @error("trans.$locale.name") <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Описание</label>
                                                <textarea wire:model.defer="trans.{{ $locale }}.description"
                                                          class="form-control"
                                                          placeholder="Описание на {{ $locale }}"
                                                          rows="4"></textarea>
                                                @error("trans.$locale.description") <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            {{-- Buttons --}}
                            <div class="form-group mb-0 mt-4">
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                    Сохранить
                                </button>
                                <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary waves-effect waves-light">
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
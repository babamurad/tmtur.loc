<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Добавить новую страницу</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.pages.index') }}">Страницы</a></li>
                        <li class="breadcrumb-item active">Создание</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Данные страницы</h5>

                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                        @endif

                        <form wire:submit.prevent="storePage">
                            {{-- AI Translation Buttons --}}
                            <div class="mb-3 text-end">
                                <x-gemini-translation-buttons :duration="$translationDuration" />
                            </div>

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

                            <div class="tab-content">
                                @foreach(config('app.available_locales') as $index => $locale)
                                    <div class="tab-pane {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $locale }}"
                                        role="tabpanel">

                                        @if($locale === config('app.fallback_locale'))
                                            {{-- Main locale fields --}}
                                            <div class="form-group">
                                                <label class="form-label">Заголовок <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                    placeholder="Введите заголовок страницы" wire:model.live="title">
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Slug (URL) <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                    placeholder="URL страницы" wire:model="slug">
                                                @error('slug')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Контент</label>
                                                <x-quill wire:model="content" />
                                                @error('content')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group form-check">
                                                <input type="checkbox" class="form-check-input" id="isPublished"
                                                    wire:model="is_published">
                                                <label class="form-check-label" for="isPublished">Опубликовано</label>
                                            </div>

                                        @else
                                            {{-- Translation fields --}}
                                            <div class="form-group">
                                                <label>Заголовок</label>
                                                <input type="text" wire:model.defer="trans.{{ $locale }}.title"
                                                    class="form-control" placeholder="Заголовок на {{ $locale }}">
                                                @error("trans.$locale.title") <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Контент</label>
                                                <x-quill wire:model.defer="trans.{{ $locale }}.content" />
                                                @error("trans.$locale.content") <span class="text-danger">{{ $message }}</span>
                                                @enderror
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
                                <button type="button" wire:click="storePage(true)"
                                    class="btn btn-primary waves-effect waves-light mr-2">
                                    <i class="bx bx-plus font-size-16 align-middle mr-1"></i>
                                    Сохранить и создать
                                </button>
                                <a href="{{ route('admin.pages.index') }}"
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
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 font-size-18">Создание нового тега</h4>
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                        <i class="bx bx-arrow-back"></i> Назад
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <form wire:submit.prevent="save">

                            <h4 class="card-title mb-4">Название тега</h4>

                            <div class="alert alert-info">
                                Введите название тега для каждого языка.
                            </div>

                            <div class="mb-3 text-end">
                                <x-gemini-translation-buttons :duration="$translationDuration" />
                            </div>

                            @foreach(config('app.available_locales') as $locale)
                                <div class="form-group mb-4">
                                    <label class="text-uppercase font-weight-bold">{{ $locale }}</label>
                                    <input type="text" class="form-control" wire:model="trans.{{ $locale }}.name"
                                        placeholder="Название на {{ $locale }}...">
                                </div>
                            @endforeach

                            <div class="form-group mt-4 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-plus"></i> Создать
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 font-size-18">Редактирование тега</h4>
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

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-0">Название тега</h4>
                                <x-gemini-translation-buttons :duration="$translationDuration" />
                            </div>

                            <div class="alert alert-info">
                                Введите название тега для каждого языка.
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
                                    <i class="bx bx-save"></i> Сохранить
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Optional: Show usage stats or info -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Информация</h4>
                        <p>ID: {{ $tag->id }}</p>
                        <p>Туров с этим тегом: {{ $tag->tours()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="page-content">
    <div class="container-fluid">
        <div>
            <h2>Редактировать включение</h2>

            <form wire:submit.prevent="save">
                <div class="card">
                    <div class="card-body">
                        @foreach(config('app.available_locales') as $locale)
                            <div class="mb-3">
                                <label class="form-label">Название ({{ strtoupper($locale) }})</label>
                                <input type="text" class="form-control" wire:model="trans.{{ $locale }}.title">
                                @error("trans.$locale.title") <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="{{ route('inclusions.index') }}" class="btn btn-secondary">Отмена</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


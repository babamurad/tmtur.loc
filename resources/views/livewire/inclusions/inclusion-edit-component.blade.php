<div class="page-content">
    <div class="container-fluid">
        <div>
            <form wire:submit.prevent="save">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Редактировать включение</h4>
                            <x-gemini-translation-buttons :duration="$translationDuration" />
                        </div>
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
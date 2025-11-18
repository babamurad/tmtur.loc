<div>
    @if (session()->has('message'))
        <div style="color:green;margin-bottom:1rem">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save">
        @foreach(config('app.available_locales') as $locale)
            <h4>{{ strtoupper($locale) }}</h4>
            @foreach($fields as $field)
                <label>{{ $field }}</label>
                <textarea
                    wire:model="trans.{{ $locale }}.{{ $field }}"
                    placeholder="{{ $field }} ({{ $locale }})"
                ></textarea>
                @error("trans.$locale.$field") <span style="color:red">{{ $message }}</span> @enderror
            @endforeach
        @endforeach

        <button type="submit">Сохранить переводы</button>
    </form>
</div>

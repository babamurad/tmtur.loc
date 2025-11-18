<div class="btn-group" role="group" aria-label="Language switcher">
    @foreach ($locales as $code)
        <button
            type="button"
            wire:click="switch('{{ $code }}')"
            class="btn btn-sm btn-secondary rounded {{ $code === $current ? 'btn-primary active' : '' }}"
            aria-current="{{ $code === $current ? 'true' : 'false' }}"
            title="{{ __('Switch to :lang', ['lang' => strtoupper($code)]) }}"
        >
            {{ strtoupper($code) }}
        </button>
    @endforeach
</div>

@script
<script>
    // Livewire.on('languageChanged', () => location.reload());
    Livewire.on('languageChanged', () => {
        document.body.classList.add('loading');
        location.reload();
    });
</script>
@endscript

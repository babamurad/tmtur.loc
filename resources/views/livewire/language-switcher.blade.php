<div class="dropdown">
    <button class="btn btn-link text-decoration-none dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="box-shadow: none; color: #6B7280;">
        {{ strtoupper($current) }}
    </button>
    <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="languageDropdown">
        @foreach ($locales as $code)
            <button
                type="button"
                wire:click="switch('{{ $code }}')"
                class="dropdown-item text-center mb-1 rounded btn-sm {{ $code === $current ? 'active' : '' }}"
            >
                {{ strtoupper($code) }}
            </button>
        @endforeach
    </div>
</div>

@script
<script>
    // Livewire.on('languageChanged', () => location.reload());
    Livewire.on('languageChanged', () => {
        // Закрываем мобильное меню перед перезагрузкой
        var navbar = $('.navbar-collapse');
        if (navbar.hasClass('show')) {
            navbar.collapse('hide');
        }
        
        document.body.classList.add('loading');
        location.reload();
    });
    
    // Закрываем dropdown после выбора языка на мобильных устройствах
    $wire.on('languageChanged', () => {
        $('#languageDropdown').dropdown('hide');
    });
</script>
@endscript

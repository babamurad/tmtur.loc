{{-- AI Translation Buttons Component --}}
@props(['duration' => null])
<div class="mb-3 d-flex flex-wrap gap-2">
    <button type="button" wire:click="translateToAllLanguages" wire:loading.attr="disabled"
        class="btn btn-sm btn-outline-info" title="Автоматический перевод на все языки через Gemini AI">
        <span wire:loading.remove wire:target="translateToAllLanguages">
            <i class="fas fa-globe"></i> Перевести на все языки
        </span>
        <span wire:loading wire:target="translateToAllLanguages">
            <i class="fas fa-spinner fa-spin"></i> Перевожу все...
        </span>
    </button>

    @if($duration)
        <span class="text-success small align-self-center font-weight-bold" wire:loading.remove>
            <i class="bx bx-time-five"></i> {{ $duration }} сек.
        </span>
    @endif
</div>
{{-- AI Translation Buttons Component --}}
@props(['duration' => null])
<div class="mb-3 d-flex flex-wrap gap-2">
    <button type="button" wire:click="autoTranslateToEnglish" wire:loading.attr="disabled"
        class="btn btn-sm btn-outline-primary" title="Автоматический перевод на английский через Gemini AI">
        <span wire:loading.remove wire:target="autoTranslateToEnglish">
            <i class="fas fa-language"></i> EN перевод
        </span>
        <span wire:loading wire:target="autoTranslateToEnglish">
            <i class="fas fa-spinner fa-spin"></i> Перевожу...
        </span>
    </button>

    <button type="button" wire:click="autoTranslateToKorean" wire:loading.attr="disabled"
        class="btn btn-sm btn-outline-success" title="Автоматический перевод на корейский через Gemini AI">
        <span wire:loading.remove wire:target="autoTranslateToKorean">
            <i class="fas fa-language"></i> KO перевод
        </span>
        <span wire:loading wire:target="autoTranslateToKorean">
            <i class="fas fa-spinner fa-spin"></i> Перевожу...
        </span>
    </button>

    <button type="button" wire:click="translateToAllLanguages" wire:loading.attr="disabled"
        class="btn btn-sm btn-outline-info" title="Автоматический перевод на все языки через Gemini AI">
        <span wire:loading.remove wire:target="translateToAllLanguages">
            <i class="fas fa-globe"></i> Все языки
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
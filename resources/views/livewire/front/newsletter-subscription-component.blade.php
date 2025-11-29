<div>
    <div class="font-weight-bold mb-2">{{ __('layout.subscribe_newsletter') }}</div>
    
    @if($successMessage)
        <div class="alert alert-success alert-dismissible fade show small p-2 mb-2" role="alert">
            {{ $successMessage }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" wire:click="$set('successMessage', '')">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errorMessage)
        <div class="alert alert-danger alert-dismissible fade show small p-2 mb-2" role="alert">
            {{ $errorMessage }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" wire:click="$set('errorMessage', '')">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form wire:submit.prevent="subscribe" class="form-inline">
        <input 
            type="email" 
            class="form-control form-control-sm mr-2 @error('email') is-invalid @enderror" 
            placeholder="{{ __('layout.your_email') }}" 
            wire:model.defer="email"
            required
        >
        <button 
            type="submit" 
            class="btn btn-sm btn-danger" 
            wire:loading.attr="disabled"
            wire:target="subscribe"
        >
            <span wire:loading.remove wire:target="subscribe">
                <i class="fa-solid fa-paper-plane"></i>
            </span>
            <span wire:loading wire:target="subscribe">
                <i class="fa-solid fa-spinner fa-spin"></i>
            </span>
        </button>
        @error('email')
            <div class="invalid-feedback d-block small">{{ $message }}</div>
        @enderror
    </form>
</div>

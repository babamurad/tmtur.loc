<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade tm-modal" id="contactModal" tabindex="-1" role="dialog"
        aria-labelledby="contactModalLabel" aria-hidden="true" style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="tm-modal-header">
                    <button type="button" class="close tm-modal-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <div class="d-flex align-items-center">
                        <div class="tm-icon-circle">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">
                                {{ __('messages.contact_us') ?? 'Contact Us' }}
                            </h5>
                            <p class="mb-0">
                                {{ __('messages.leave_message_contact') ?? 'Оставьте нам сообщение и мы свяжемся с вами' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tm-modal-body">
                    @if ($sent)
                        <div class="alert alert-success text-center">
                            <i class="fas fa-check-circle fa-2x mb-3"></i><br>
                            {{ __('messages.message_sent') ?? 'Your message has been sent successfully!' }}
                        </div>
                    @else

                        <form wire:submit="submit">
                            <div class="form-group">
                                <label for="contact_name" class="tm-form-label">{{ __('messages.name') ?? 'Name' }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control tm-form-control @error('name') is-invalid @enderror"
                                    id="contact_name" wire:model="name"
                                    placeholder="{{ __('messages.your_name') ?? 'Your Name' }}">
                                @error('name') <div class="tm-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="contact_email" class="tm-form-label">{{ __('messages.email') ?? 'Email' }} <span
                                        class="text-danger">*</span></label>
                                <input type="email"
                                    class="form-control tm-form-control @error('email') is-invalid @enderror"
                                    id="contact_email" wire:model="email"
                                    placeholder="{{ __('messages.your_email') ?? 'name@example.com' }}">
                                @error('email') <div class="tm-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="contact_phone"
                                    class="tm-form-label">{{ __('messages.phone') ?? 'Phone' }}</label>
                                <input type="text" class="form-control tm-form-control @error('phone') is-invalid @enderror"
                                    id="contact_phone" wire:model="phone"
                                    placeholder="{{ __('messages.your_phone') ?? '+993...' }}">
                                @error('phone') <div class="tm-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="contact_message"
                                    class="tm-form-label">{{ __('messages.message') ?? 'Message' }}</label>
                                <textarea
                                    class="form-control tm-form-control tm-textarea @error('message') is-invalid @enderror"
                                    id="contact_message" wire:model="message" rows="3"
                                    placeholder="{{ __('messages.your_message') ?? '...' }}"></textarea>
                                @error('message') <div class="tm-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('messages.close') ?? 'Close' }}</button>
                                <button type="submit" class="btn tm-order-btn text-white">
                                    <span wire:loading.remove
                                        wire:target="submit">{{ __('messages.send') ?? 'Send' }}</span>
                                    <span wire:loading wire:target="submit"><i class="fas fa-spinner fa-spin"></i>
                                        {{ __('messages.sending') ?? 'Sending...' }}</span>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
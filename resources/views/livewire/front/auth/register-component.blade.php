<div class="auth-page py-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card auth-card shadow-lg border-0 rounded-lg">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="auth-icon mb-2">
                                <i class="fa-regular fa-id-card fa-lg"></i>
                            </div>
                            <h2 class="mb-1 text-center font-weight-bold">{{ __('auth.register_title') }}</h2>
                            <p class="text-muted text-center mb-1 small">{{ __('auth.register_subtitle') }}</p>
                            <p class="text-muted small mb-0">{{ __('auth.have_account') }} <a
                                    href="{{ route('front.login') }}" class="font-weight-bold"
                                    wire:navigate>{{ __('auth.sign_in_link') }}</a></p>
                        </div>

                        <form wire:submit.prevent="register">
                            <div class="form-group mb-3">
                                <label for="frontName" class="font-weight-bold small mb-1">{{ __('auth.name') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 text-muted">
                                            <i class="fa-regular fa-user"></i>
                                        </span>
                                    </div>
                                    <input id="frontName" type="text"
                                        class="form-control border-left-0 pl-0 @error('name') is-invalid @enderror"
                                        placeholder="John Doe" wire:model.defer="name">
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="frontEmail" class="font-weight-bold small mb-1">{{ __('auth.email') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 text-muted">
                                            <i class="fa-regular fa-envelope"></i>
                                        </span>
                                    </div>
                                    <input id="frontEmail" type="email"
                                        class="form-control border-left-0 pl-0 @error('email') is-invalid @enderror"
                                        placeholder="name@example.com" wire:model.defer="email">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="frontPassword" class="font-weight-bold small mb-1">{{ __('auth.password') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 text-muted">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                    </div>
                                    <input id="frontPassword" type="password"
                                        class="form-control border-left-0 pl-0 @error('password') is-invalid @enderror"
                                        placeholder="********" wire:model.defer="password">
                                </div>
                                <small class="form-hint d-block mt-1 text-muted" style="font-size: 0.75rem;">Min 8 chars, letters & numbers.</small>
                                @error('password')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="frontPasswordConfirmation"
                                    class="font-weight-bold small mb-1">{{ __('auth.password_confirmation') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 text-muted">
                                            <i class="fa-solid fa-shield"></i>
                                        </span>
                                    </div>
                                    <input id="frontPasswordConfirmation" type="password"
                                        class="form-control border-left-0 pl-0 @error('password_confirmation') is-invalid @enderror"
                                        placeholder="********" wire:model.defer="password_confirmation">
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3 text-center">
                                <p class="text-muted small" style="font-size: 0.75rem;">
                                    {!! __('auth.agree_terms', ['terms_url' => route('terms'), 'privacy_url' => route('privacy')]) !!}
                                </p>
                            </div>

                            <button type="submit"
                                class="btn btn-primary btn-block auth-cta">{{ __('auth.sign_up_button') }}</button>
                        </form>

                        <div class="auth-divider text-center small my-3">{{ __('auth.or_continue') ?? 'или продолжить' }}
                        </div>

                        <div class="text-center">
                            <span class="text-muted small">{{ __('auth.have_account') }}</span>
                            <a href="{{ route('front.login') }}" class="text-primary font-weight-bold small"
                                wire:navigate>{{ __('auth.sign_in_link') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
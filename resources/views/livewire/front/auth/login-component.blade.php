<div class="auth-page py-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 pt-5 pb-2">
                <div class="card auth-card shadow-lg border-0 rounded-lg">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="auth-icon mb-2">
                                <i class="fa-solid fa-unlock-alt fa-lg"></i>
                            </div>
                            <h2 class="mb-1 text-center font-weight-bold">{{ __('auth.login_title') }}</h2>
                            <p class="text-muted text-center mb-1 small">{{ __('auth.login_subtitle') }}</p>
                            <p class="text-muted small mb-0">{{ __('auth.no_account') }} <a
                                    href="{{ route('front.register') }}" class="font-weight-bold"
                                    wire:navigate>{{ __('auth.sign_up_link') }}</a></p>
                        </div>

                        <form wire:submit.prevent="login">
                            <div class="form-group mb-3">
                                <label for="frontEmail"
                                    class="font-weight-bold small mb-1">{{ __('auth.email') }}</label>
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
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="frontPassword"
                                        class="mb-0 font-weight-bold small">{{ __('auth.password') }}</label>
                                    <a href="#" class="small text-primary auth-muted-link"
                                        style="font-size: 0.75rem;">{{ __('auth.forgot_password') }}</a>
                                </div>
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
                                @error('password')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="frontRemember">
                                <label class="custom-control-label small"
                                    for="frontRemember">{{ __('auth.remember') }}</label>
                            </div>

                            <button type="submit"
                                class="btn btn-primary btn-block auth-cta">{{ __('auth.sign_in') }}</button>
                        </form>

                        <div class="auth-divider text-center small my-3">
                            {{ __('auth.or_continue') ?? 'или продолжить' }}
                        </div>

                        <div class="mb-3">
                            <a href="{{ route('auth.google') }}" class="btn btn-outline-danger btn-block auth-cta">
                                <i class="fa-brands fa-google me-2"></i>
                                {{ __('auth.google_login') ?? 'Войти через Google' }}
                            </a>
                        </div>

                        <div class="text-center">
                            <span class="text-muted small">{{ __('auth.no_account') }}</span>
                            <a href="{{ route('front.register') }}" class="text-primary font-weight-bold small"
                                wire:navigate>{{ __('auth.sign_up_link') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
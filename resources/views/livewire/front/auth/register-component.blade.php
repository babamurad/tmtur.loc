<div class="auth-page py-6">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card auth-card shadow-lg border-0 rounded-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="auth-icon mb-3">
                                <i class="fa-regular fa-id-card fa-lg"></i>
                            </div>
                            <h2 class="mb-2 text-center font-weight-bold">{{ __('auth.register_title') }}</h2>
                            <p class="text-muted text-center mb-1 small">{{ __('auth.register_subtitle') }}</p>
                            <p class="text-muted small mb-0">{{ __('auth.have_account') }} <a href="{{ route('front.login') }}" class="font-weight-bold" wire:navigate>{{ __('auth.sign_in_link') }}</a></p>
                        </div>

                        <form wire:submit.prevent="register">
                            <div class="form-group">
                                <label for="frontName" class="font-weight-bold">{{ __('auth.name') }}</label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 text-muted">
                                            <i class="fa-regular fa-user"></i>
                                        </span>
                                    </div>
                                    <input id="frontName"
                                           type="text"
                                           class="form-control form-control-lg border-left-0 pl-0 @error('name') is-invalid @enderror"
                                           placeholder="John Doe"
                                           wire:model.defer="name">
                                </div>
                                <small class="form-hint d-block mt-1">{{ __('auth.name') }}</small>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="frontEmail" class="font-weight-bold">{{ __('auth.email') }}</label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 text-muted">
                                            <i class="fa-regular fa-envelope"></i>
                                        </span>
                                    </div>
                                    <input id="frontEmail"
                                           type="email"
                                           class="form-control form-control-lg border-left-0 pl-0 @error('email') is-invalid @enderror"
                                           placeholder="name@example.com"
                                           wire:model.defer="email">
                                </div>
                                <small class="form-hint d-block mt-1">{{ __('auth.login_subtitle') }}</small>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="frontPassword" class="font-weight-bold">{{ __('auth.password') }}</label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 text-muted">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                    </div>
                                    <input id="frontPassword"
                                           type="password"
                                           class="form-control form-control-lg border-left-0 pl-0 @error('password') is-invalid @enderror"
                                           placeholder="********"
                                           wire:model.defer="password">
                                </div>
                                <small class="form-hint d-block mt-1">Минимум 8 символов, латиница и цифры.</small>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="frontPasswordConfirmation" class="font-weight-bold">{{ __('auth.password_confirmation') }}</label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 text-muted">
                                            <i class="fa-solid fa-shield"></i>
                                        </span>
                                    </div>
                                    <input id="frontPasswordConfirmation"
                                           type="password"
                                           class="form-control form-control-lg border-left-0 pl-0 @error('password_confirmation') is-invalid @enderror"
                                           placeholder="********"
                                           wire:model.defer="password_confirmation">
                                </div>
                                <small class="form-hint d-block mt-1">{{ __('auth.password_confirmation') }}</small>
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="custom-control custom-checkbox mb-4">
                                <input type="checkbox"
                                       class="custom-control-input @error('agree') is-invalid @enderror"
                                       id="frontAgree"
                                       wire:model="agree">
                                <label class="custom-control-label" for="frontAgree">{{ __('auth.agree_terms') }}</label>
                               @error('agree')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block auth-cta">{{ __('auth.sign_up_button') }}</button>
                        </form>

                        <div class="auth-divider text-center small">{{ __('auth.or_continue') ?? 'или продолжить' }}</div>

                        <div class="text-center mt-3">
                            <span class="text-muted">{{ __('auth.have_account') }}</span>
                            <a href="{{ route('front.login') }}" class="text-primary font-weight-bold" wire:navigate>{{ __('auth.sign_in_link') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

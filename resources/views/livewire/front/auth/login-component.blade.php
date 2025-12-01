<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="mb-3 text-center">{{ __('auth.login_title') }}</h3>
                        <p class="text-muted text-center mb-4">{{ __('auth.login_subtitle') }}</p>

                        <form wire:submit.prevent="login">
                            <div class="form-group">
                                <label for="frontEmail">{{ __('auth.email') }}</label>
                                <input id="frontEmail"
                                       type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="name@example.com"
                                       wire:model.defer="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="frontPassword" class="mb-0">{{ __('auth.password') }}</label>
                                    <a href="#" class="small text-secondary">{{ __('auth.forgot_password') }}</a>
                                </div>
                                <input id="frontPassword"
                                       type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="********"
                                       wire:model.defer="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="frontRemember">
                                <label class="custom-control-label" for="frontRemember">{{ __('auth.remember') }}</label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">{{ __('auth.sign_in') }}</button>
                        </form>

                        <div class="text-center mt-4">
                            <span class="text-muted">{{ __('auth.no_account') }}</span>
                            <a href="{{ route('front.register') }}" class="font-weight-bold" wire:navigate>{{ __('auth.sign_up_link') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="mb-3 text-center">{{ __('auth.register_title') }}</h3>
                        <p class="text-muted text-center mb-4">{{ __('auth.register_subtitle') }}</p>

                        <form wire:submit.prevent="register">
                            <div class="form-group">
                                <label for="frontName">{{ __('auth.name') }}</label>
                                <input id="frontName"
                                       type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="John Doe"
                                       wire:model.defer="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

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
                                <label for="frontPassword">{{ __('auth.password') }}</label>
                                <input id="frontPassword"
                                       type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="********"
                                       wire:model.defer="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="frontPasswordConfirmation">{{ __('auth.password_confirmation') }}</label>
                                <input id="frontPasswordConfirmation"
                                       type="password"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       placeholder="********"
                                       wire:model.defer="password_confirmation">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox"
                                       class="custom-control-input @error('agree') is-invalid @enderror"
                                       id="frontAgree"
                                       wire:model="agree">
                                <label class="custom-control-label" for="frontAgree">{{ __('auth.agree_terms') }}</label>
                                @error('agree')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">{{ __('auth.sign_up_button') }}</button>
                        </form>

                        <div class="text-center mt-4">
                            <span class="text-muted">{{ __('auth.have_account') }}</span>
                            <a href="{{ route('front.login') }}" class="font-weight-bold" wire:navigate>{{ __('auth.sign_in_link') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

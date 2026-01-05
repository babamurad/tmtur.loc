<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center min-vh-100">
                <div class="w-100 d-block my-5">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center mb-4 mt-3">
                                        <a href="/">
                                            <h2>TmTourism</h2>
                                        </a>
                                    </div>
                                    <form wire:submit.prevent="register" class="p-2">
                                        <div class="form-group">
                                            <label for="username">Name</label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text"
                                                id="username" placeholder="Enter your name" value="{{ old('name') }}"
                                                wire:model="name">
                                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="emailaddress">Email address</label>
                                            <input class="form-control @error('email') is-invalid @enderror"
                                                type="email" id="emailaddress" placeholder="Your Email"
                                                wire:model="email">
                                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input class="form-control @error('password') is-invalid @enderror"
                                                type="password" id="password" placeholder="Enter your password"
                                                wire:model="password">
                                            @error('password')<div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <input class="form-control" type="password" id="password_confirmation"
                                                placeholder="Confirm your password" wire:model="password_confirmation">
                                        </div>
                                        <div class="form-group mb-4 pb-3 text-center">
                                            <p class="text-muted">
                                                {!! __('auth.agree_terms', ['terms_url' => route('terms'), 'privacy_url' => route('privacy')]) !!}
                                            </p>
                                        </div>
                                        <div class="mb-3 text-center">
                                            <button class="btn btn-primary btn-block" type="submit"> Sign Up Free
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card -->

                            <div class="row mt-4">
                                <div class="col-sm-12 text-center">
                                    <p class="text-white-50 mb-0">Already have an account? <a
                                            href="{{ route('login') }}" class="text-white-50 ml-1" wire:navigate>
                                            <b>Sign In</b></a>
                                    </p>
                                </div>
                            </div>

                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- end .w-100 -->
            </div> <!-- end .d-flex -->
        </div> <!-- end col-->
    </div> <!-- end row -->
</div>
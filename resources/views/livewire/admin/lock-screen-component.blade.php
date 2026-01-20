<div>
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
                                                <span><img src="{{ asset('assets/images/logo-dark.png') }}" alt=""
                                                        height="26"></span>
                                            </a>
                                            <div class="mt-4 pt-1">
                                                <img src="{{ $user->avatar ? $user->avatar->url : asset('assets/images/users/avatar-1.jpg') }}"
                                                    class="rounded-circle img-thumbnail" alt="thumbnail"
                                                    style="height:88px;">
                                            </div>
                                            <h5 class="font-size-15 mt-3">{{ $user->name }}</h5>
                                            <p class="text-muted mb-0 font-13 mt-3">Введите пароль, чтобы разблокировать
                                                экран.</p>
                                        </div>
                                        <form wire:submit="unlock" class="p-2">
                                            <div class="form-group">
                                                <label for="password">Пароль</label>
                                                <input class="form-control" type="password" required="" id="password"
                                                    placeholder="Введите ваш пароль" wire:model="password">
                                                @error('password') <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 text-center">
                                                <button class="btn btn-primary btn-block" type="submit"> Разблокировать
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->

                                <div class="row mt-4">
                                    <div class="col-sm-12 text-center">
                                        <p class="text-white-50 mb-0">Не вы? <a href="javascript:void(0)"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                class="text-white-50 ml-1"><b>Выйти</b></a></p>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
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
</div>
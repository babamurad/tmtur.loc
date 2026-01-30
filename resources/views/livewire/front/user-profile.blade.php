<div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                    <div class="card-header bg-white border-bottom p-4">
                        <h2 class="h4 mb-0 font-weight-bold text-dark">
                            {{ __('Edit Profile') ?? 'Редактировать профиль' }}
                        </h2>
                    </div>
                    <div class="card-body p-4 p-md-5">

                        {{-- Success Message --}}
                        @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form wire:submit="updateProfile">
                            <div class="row g-4">
                                {{-- Left Column: Avatar --}}
                                <div class="col-md-4 text-center border-end-md">
                                    <div class="mb-4">
                                        <div class="position-relative d-inline-block">
                                            @if ($avatar)
                                                <img src="{{ $avatar->temporaryUrl() }}"
                                                    class="rounded-circle img-thumbnail shadow-sm object-cover"
                                                    style="width: 150px; height: 150px; object-fit: cover;"
                                                    alt="New Avatar">
                                            @elseif ($currentAvatarUrl)
                                                <img src="{{ $currentAvatarUrl }}"
                                                    class="rounded-circle img-thumbnail shadow-sm object-cover"
                                                    style="width: 150px; height: 150px; object-fit: cover;"
                                                    alt="Current Avatar">
                                            @else
                                                <img src="{{ asset('assets/images/users/avatar-1.jpg') }}"
                                                    class="rounded-circle img-thumbnail shadow-sm"
                                                    style="width: 150px; height: 150px; object-fit: cover;"
                                                    alt="Default Avatar">
                                            @endif

                                            <div wire:loading wire:target="avatar"
                                                class="position-absolute top-50 start-50 translate-middle">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="sr-only" style="display:none;">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="avatar" class="btn btn-outline-primary btn-sm w-100 mb-2">
                                            <i class="fa-solid fa-camera mr-2"></i>
                                            {{ __('Change Photo') ?? 'Изменить фото' }}
                                            <input type="file" id="avatar" wire:model="avatar" class="d-none"
                                                accept="image/*">
                                        </label>

                                        @if($currentAvatarUrl && !$avatar)
                                            <button type="button" class="btn btn-outline-danger btn-sm w-100"
                                                wire:click="confirmDeleteAvatar">
                                                <i class="fa-solid fa-trash mr-2"></i> {{ __('Remove Photo') ?? 'Удалить' }}
                                            </button>
                                        @endif
                                    </div>
                                    @error('avatar') <p class="text-danger small">{{ $message }}</p> @enderror
                                    <p class="text-muted small mb-0">
                                        {{ __('Allowed: jpg, jpeg, png. Max: 1MB') ?? 'Разрешены: jpg, jpeg, png. Макс: 1MB' }}
                                    </p>
                                </div>

                                {{-- Right Column: Form Fields --}}
                                <div class="col-md-8 ps-md-4">
                                    <h5 class="mb-4 text-muted border-bottom pb-2">
                                        {{ __('Personal Information') ?? 'Личная информация' }}
                                    </h5>

                                    {{-- Name --}}
                                    <div class="mb-3 form-group">
                                        <label for="name"
                                            class="form-label fw-bold small text-uppercase text-muted">{{ __('Full Name') ?? 'ФИО' }}</label>
                                        <input type="text"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            id="name" wire:model="name">
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="mb-4 form-group">
                                        <label for="email"
                                            class="form-label fw-bold small text-uppercase text-muted">{{ __('Email Address') ?? 'Email адрес' }}</label>
                                        <input type="email"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            id="email" wire:model="email">
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <h5 class="mb-4 text-muted border-bottom pb-2 mt-5">
                                        {{ __('Security') ?? 'Безопасность' }}
                                    </h5>
                                    <p class="text-muted small mb-3">
                                        {{ __('Leave blank if you don\'t want to change password.') ?? 'Оставьте пустым, если не хотите менять пароль.' }}
                                    </p>

                                    {{-- Current Password --}}
                                    <div class="mb-3 form-group">
                                        <label for="current_password"
                                            class="form-label fw-bold small text-uppercase text-muted">{{ __('Current Password') ?? 'Текущий пароль' }}</label>
                                        <input type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="current_password" wire:model="current_password">
                                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            {{-- New Password --}}
                                            <div class="mb-3 form-group">
                                                <label for="password"
                                                    class="form-label fw-bold small text-uppercase text-muted">{{ __('New Password') ?? 'Новый пароль' }}</label>
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" wire:model="password">
                                                @error('password') <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- Confirm Password --}}
                                            <div class="mb-4 form-group">
                                                <label for="password_confirmation"
                                                    class="form-label fw-bold small text-uppercase text-muted">{{ __('Confirm Password') ?? 'Подтверждение' }}</label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    wire:model="password_confirmation">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end pt-3">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm"
                                            wire:loading.attr="disabled">
                                            <span wire:loading.remove
                                                wire:target="updateProfile">{{ __('Save Changes') ?? 'Сохранить изменения' }}</span>
                                            <span wire:loading wire:target="updateProfile">
                                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                                    aria-hidden="true"></span>
                                                {{ __('Saving...') ?? 'Сохранение...' }}
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
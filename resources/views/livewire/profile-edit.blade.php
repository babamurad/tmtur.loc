<div class="page-content">
    <div class="container-fluid">
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form wire:submit.prevent="updateProfile">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Main info</h5>

                            <!-- Avatar -->
                            <div class="form-group">
                                <label for="avatar">Avatar</label>
                                @if ($avatar)
                                    <div class="mb-2">
                                        <img src="{{ $avatar->temporaryUrl() }}" width="100" height="100"
                                            class="rounded-circle" alt="Avatar Preview">
                                    </div>
                                @elseif (auth()->user()->avatar)
                                    <div class="mb-2">
                                        <img src="{{ auth()->user()->avatar->url }}" width="100" height="100" class="rounded-circle" alt="Current Avatar">
                                        <button type="button" class="btn btn-sm btn-danger ml-2" wire:click="deleteAvatar" wire:confirm="Are you sure you want to delete your avatar?">
                                            <i class="mdi mdi-trash-can"></i> Delete
                                        </button>
                                    </div>
                                @else
                                    <div class="mb-2">
                                        <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" width="100" height="100"
                                            class="rounded-circle" alt="Default Avatar">
                                    </div>
                                @endif

                                <input type="file" class="form-control-file @error('avatar') is-invalid @enderror"
                                    id="avatar" wire:model="avatar">
                                @error('avatar') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <!-- Name -->
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    wire:model="name">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    wire:model="email">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- Password Change -->
                            <h5>Change Password (optional)</h5>

                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" wire:model="current_password">
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" wire:model="password">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    wire:model="password_confirmation">
                                @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Update Profile</button>
                </div>
            </div>

        </form>
    </div>
</div>
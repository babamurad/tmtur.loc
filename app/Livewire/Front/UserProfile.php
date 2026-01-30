<?php

namespace App\Livewire\Front;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserProfile extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'confirmedDeleteAvatar'
    ];

    public $name;
    public $email;
    public $currentAvatarUrl;
    public $avatar;
    public $current_password;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'current_password' => 'required_with:password',
        'password' => 'nullable|min:8|confirmed',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->currentAvatarUrl = $user->avatar?->url;
    }

    public function updateProfile()
    {
        $this->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:1024', // 1MB Max
        ]);

        $user = Auth::user();

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public_uploads');

            // Delete old avatar if exists
            if ($user->avatar) {
                // Optional: Delete physical file if needed
                // Storage::disk('public_uploads')->delete($user->avatar->file_path);
                $user->avatar()->delete();
            }

            $user->avatar()->create([
                'file_path' => $path,
                'file_name' => $this->avatar->getClientOriginalName(),
                'mime_type' => $this->avatar->getMimeType(),
                'model_type' => get_class($user),
                'model_id' => $user->id,
            ]);

            $user->refresh();
            $this->currentAvatarUrl = $user->avatar->url; // Use accessor
            $this->avatar = null;
        }
        $user->name = $this->name;
        $user->email = $this->email;

        // Обновляем пароль, если указан
        if (!empty($this->password)) {
            $this->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', __('profile.current_password_incorrect'));
                return;
            }

            $user->password = Hash::make($this->password);
        }

        $user->save();

        LivewireAlert::title(__('profile.profile_updated_title'))
            ->text(__('profile.profile_updated_text'))
            ->success()
            ->toast()
            ->position('center')
            ->show();

        // Reset password fields
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        $this->dispatch('profile-updated');
    }

    public function confirmDeleteAvatar()
    {
        LivewireAlert::title(__('profile.delete_confirm_title'))
            ->text(__('profile.delete_confirm_text'))
            ->question()
            ->withConfirmButton(__('profile.confirm_yes'))
            ->withCancelButton(__('profile.confirm_cancel'))
            ->onConfirm('confirmedDeleteAvatar')
            ->show();
    }

    public function confirmedDeleteAvatar()
    {
        $user = Auth::user();
        if ($user->avatar) {
            // Optional: Delete physical file if needed
            // Storage::disk('public_uploads')->delete($user->avatar->file_path);
            $user->avatar()->delete();
        }

        $this->avatar = null;
        $this->currentAvatarUrl = null;

        LivewireAlert::title(__('profile.avatar_removed_title'))
            ->text(__('profile.avatar_removed_text'))
            ->success()
            ->toast()
            ->position('top-end')
            ->show();

        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.front.user-profile')
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

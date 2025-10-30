<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileEdit extends Component
{
    public $name;
    public $email;
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
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;

        // Обновляем пароль, если указан
        if (!empty($this->password)) {
            $this->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'The current password is incorrect.');
                return;
            }

            $user->password = Hash::make($this->password);
        }

        $user->save();

        LivewireAlert::title('Profile data saved')
            ->text('Profile data has been successfully saved!')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.profile-edit');
    }
}

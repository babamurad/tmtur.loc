<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use App\Models\User;

class RegisterComponent extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $agree;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'agree' => 'accepted',
    ];

    public function register()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 0, // обычный пользователь
            'referer' => app(\Spatie\Referer\Referer::class)->get(),
        ]);

        session()->flash('registered', [
            'title' => 'Регистрация!',
            'text' => 'Регистрация успешна завершена!',
        ]);

        $this->reset();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.register-component')->layout('layouts.guest-app');
    }
}

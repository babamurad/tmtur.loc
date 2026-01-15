<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class LoginComponent extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();

            $user = Auth::user();

            session()->flash('registered', [
                'title' => 'Регистрация!',
                'text' => 'Регистрация успешна завершена!',
            ]);

            //            dd($user->role);

            return match ($user->role) {
                'admin' => redirect()->route('dashboard'),
                'referral' => redirect()->route('admin.link-generator'),
                'manager' => redirect('/'),
                default => redirect('/'),
            };
        }

        LivewireAlert::title('Неверный email или пароль..')
            ->error()
            ->toast()
            ->position('top-center')
            ->show();
    }

    public function render()
    {
        return view('livewire.auth.login-component')->layout('layouts.guest-app', [
            'title' => 'Вход в панель управления',
        ]);
    }
}

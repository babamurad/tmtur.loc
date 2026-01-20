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


    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',

    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => User::ROLE_USER,
            'referer' => app(\Spatie\Referer\Referer::class)->get(),
        ]);

        Auth::login($user);

        session()->flash('registered', [
            'title' => 'Регистрация!',
            'text' => 'Регистрация успешна завершена!',
        ]);

        // Отправка уведомления администраторам
        try {
            $admins = User::where('role', User::ROLE_ADMIN)->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\SystemNotification(
                'Новый пользователь',
                "Зарегистрировался новый пользователь: {$user->name} ({$user->email})",
                route('users.edit', $user->id),
                'bx-user-plus'
            ));
        } catch (\Exception $e) {
            // Логируем ошибку, но не прерываем регистрацию
            \Illuminate\Support\Facades\Log::error('Ошибка отправки уведомления о регистрации: ' . $e->getMessage());
        }

        $this->reset();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.register-component')->layout('layouts.guest-app', [
            'title' => 'Регистрация',
        ]);
    }
}

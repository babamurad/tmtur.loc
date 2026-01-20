<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('layouts.guest-app')] // Using existing guest layout
class LockScreenComponent extends Component
{
    #[Rule('required')]
    public $password = '';

    public $user;

    public function mount()
    {
        $this->user = Auth::user();

        if (!$this->user) {
            return redirect()->route('login');
        }

        // If not locked, lock it now if visiting this page directly? 
        // Or just show the screen? 
        // Standard behavior: if you visit lock-screen, you are effectively locked.
        if (!session('locked')) {
            session(['locked' => true]);
        }
    }

    public function unlock()
    {
        $this->validate();

        if (Hash::check($this->password, $this->user->password)) {
            session()->forget('locked');
            return redirect()->intended(route('dashboard'));
        }

        $this->addError('password', 'Неверный пароль.');
    }

    public function render()
    {
        return view('livewire.admin.lock-screen-component');
    }
}

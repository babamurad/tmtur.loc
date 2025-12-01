<?php

namespace App\Livewire\Front\Auth;

use App\Livewire\Auth\LoginComponent as BaseLoginComponent;

class LoginComponent extends BaseLoginComponent
{
    public function render()
    {
        return view('livewire.front.auth.login-component')
            ->layout('layouts.front-app', [
                'hideCarousel' => true,
                'title' => __('auth.login_title') ?? 'Login',
            ]);
    }
}

<?php

namespace App\Livewire\Front\Auth;

use App\Livewire\Auth\LoginComponent as BaseLoginComponent;

class LoginComponent extends BaseLoginComponent
{
    public function render()
    {
        $title = __('auth.login_title');
        \Artesaos\SEOTools\Facades\SEOTools::setTitle($title);

        return view('livewire.front.auth.login-component')
            ->layout('layouts.front-app', [
                'hideCarousel' => true,
                'title' => $title,
            ]);
    }
}

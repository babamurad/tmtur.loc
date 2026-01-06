<?php

namespace App\Livewire\Front\Auth;

use App\Livewire\Auth\RegisterComponent as BaseRegisterComponent;

class RegisterComponent extends BaseRegisterComponent
{
    public function render()
    {
        $title = __('auth.register_title');
        \Artesaos\SEOTools\Facades\SEOTools::setTitle($title);

        return view('livewire.front.auth.register-component')
            ->layout('layouts.front-app', [
                'hideCarousel' => true,
                'title' => $title,
            ]);
    }
}

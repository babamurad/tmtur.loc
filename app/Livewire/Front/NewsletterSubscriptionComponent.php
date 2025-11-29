<?php

namespace App\Livewire\Front;

use Livewire\Component;

class NewsletterSubscriptionComponent extends Component
{
    public $email = '';
    public $successMessage = '';
    public $errorMessage = '';

    protected $rules = [
        'email' => 'required|email|max:255',
    ];

    protected $messages = [
        'email.required' => 'Пожалуйста, введите email адрес',
        'email.email' => 'Пожалуйста, введите корректный email адрес',
        'email.max' => 'Email адрес слишком длинный',
    ];

    public function subscribe()
    {
        $this->validate();

        // Проверка на дубликат
        $existing = \App\Models\NewsletterSubscriber::where('email', $this->email)->first();
        
        if ($existing) {
            if ($existing->is_active) {
                $this->errorMessage = __('newsletter.already_subscribed');
                return;
            } else {
                // Реактивировать подписку
                $existing->update([
                    'is_active' => true,
                    'subscribed_at' => now(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
                $this->successMessage = __('newsletter.resubscribed_success');
                $this->reset('email', 'errorMessage');
                return;
            }
        }

        try {
            \App\Models\NewsletterSubscriber::create([
                'email' => $this->email,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $this->successMessage = __('newsletter.subscribed_success');
            $this->reset('email', 'errorMessage');
        } catch (\Exception $e) {
            $this->errorMessage = __('newsletter.subscription_failed');
        }
    }

    public function render()
    {
        return view('livewire.front.newsletter-subscription-component');
    }
}


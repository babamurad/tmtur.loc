<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\ContactMessage;
use App\Mail\ContactReceived;
use Illuminate\Support\Facades\Mail;

class ContactFormComponent extends Component
{
    public $name;
    public $email;
    public $phone;
    public $message;
    public $hp; // honeypot (hidden field)
    public $sending = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:50',
        'message' => 'required|string|max:5000',
        'hp' => 'nullable|prohibited', // honeypot must be empty
    ];

    protected $messages = [
        'hp.prohibited' => 'Spam detected.',
    ];

    public function submit()
    {
        $this->sending = true;
        $this->validate();

        // extra spam check: if honeypot filled — abort quietly
        if (!empty($this->hp)) {
            $this->resetForm();
            session()->flash('contact_error', 'Unable to send message.');
            return;
        }

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
        ];

        // Save to DB (if model exists)
        try {
            ContactMessage::create(array_merge($data, [
                'ip' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]));
        } catch (\Throwable $e) {
            // log but continue — don't fail UX
            \Log::error('ContactMessage save error: '.$e->getMessage());
        }

        // Send email notification (wrap in try/catch to avoid breaking UX)
        try {
            // Prioritize MAIL_TO_ADDRESS, fallback to MAIL_FROM_ADDRESS
            $recipient = env('MAIL_TO_ADDRESS') ?: config('mail.from.address');
            if ($recipient) {
                Mail::to($recipient)->send(new ContactReceived($data));
                \Log::info('Contact email sent to: ' . $recipient, ['from' => $data['email']]);
            } else {
                \Log::warning('Contact form submitted but no recipient email configured in .env');
            }
        } catch (\Throwable $e) {
            \Log::error('Contact email send error: '.$e->getMessage());
        }

        $this->resetForm();
        session()->flash('contact_success', 'Message sent. Thank you!');
        $this->dispatch('messagesUpdated');
        $this->sending = false;
    }

    public function resetForm()
    {
        $this->name = $this->email = $this->phone = $this->message = $this->hp = null;
    }

    public function render()
    {
        return view('livewire.front.contact-form-component')
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.contact'));
    }
}

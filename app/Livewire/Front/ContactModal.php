<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Mail; // Assuming we might want to mail, but for now just validation/simulated send

class ContactModal extends Component
{
    #[Rule('required|min:3')]
    public $name = '';

    #[Rule('required|email')]
    public $email = '';

    public $phone = '';

    public $message = '';

    public $isOpen = false;
    public $sent = false;

    public function submit()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
        ];

        // Save to DB
        try {
            \App\Models\ContactMessage::create(array_merge($data, [
                'ip' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]));
        } catch (\Throwable $e) {
            \Log::error('ContactMessage modal save error: ' . $e->getMessage());
        }

        // Send email
        try {
            $recipient = env('MAIL_TO_ADDRESS') ?: config('mail.from.address');
            if ($recipient) {
                Mail::to($recipient)->send(new \App\Mail\ContactReceived($data));
            }
        } catch (\Throwable $e) {
            \Log::error('Contact modal email send error: ' . $e->getMessage());
        }

        $this->sent = true;

        // Notify admin panel to update counter
        $this->dispatch('messagesUpdated');

        // Reset form
        $this->reset(['name', 'email', 'phone', 'message']);
    }

    public function render()
    {
        return view('livewire.front.contact-modal');
    }
}

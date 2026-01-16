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

        // Here you would typically send an email or save to DB
        // For now, we simulate success
        $this->sent = true;

        // Reset form
        $this->reset(['name', 'email', 'phone', 'message']);
    }

    public function render()
    {
        return view('livewire.front.contact-modal');
    }
}

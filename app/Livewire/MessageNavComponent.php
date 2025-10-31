<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Livewire\Component;

class MessageNavComponent extends Component
{
    protected $listeners = ['messagesUpdated' => '$refresh'];

    public function render()
    {
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return <<<HTML
        <li wire:poll.5s>
            <a href="{{ route('admin.contact-messages-table') }}" class="waves-effect">
                <i class='bx bx-envelope'></i>
                <span class="badge badge-pill badge-primary float-right">{$unreadCount}</span>
                <span>Messages</span>
            </a>
        </li>
        HTML;
    }
}

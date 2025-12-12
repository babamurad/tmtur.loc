<?php

namespace App\Livewire;

use App\Models\SocialLink;
use Livewire\Component;

class FooterSocialLinks extends Component
{
    public function render()
    {
        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();

        return view('livewire.footer-social-links', [
            'socialLinks' => $socialLinks,
        ]);
    }
}
<?php

namespace App\Livewire;

use App\Models\SocialLink;
use Livewire\Component;

class FooterSocialLinks extends Component
{
    public function render()
    {
        $socialLinks = \Illuminate\Support\Facades\Cache::remember('footer_social_links', 86400, function () {
            return SocialLink::where('is_active', true)->orderBy('sort_order')->get();
        });

        return view('livewire.footer-social-links', [
            'socialLinks' => $socialLinks,
        ]);
    }
}
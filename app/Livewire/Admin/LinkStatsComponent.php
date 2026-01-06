<?php

namespace App\Livewire\Admin;

use App\Models\GeneratedLink;
use Livewire\Component;
use Livewire\WithPagination;

class LinkStatsComponent extends Component
{
    use WithPagination;

    public $link;

    public function mount($id)
    {
        $this->link = GeneratedLink::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.link-stats-component', [
            'clicks' => $this->link->clicks()->latest()->paginate(20)
        ])->layout('layouts.app');
    }

    // Simple helper to parse generic OS/Browser if package is missing
    public function parseUserAgent($ua)
    {
        $platform = 'Unknown OS';
        $browser = 'Unknown Browser';

        if (preg_match('/windows|win32/i', $ua))
            $platform = 'Windows';
        elseif (preg_match('/android/i', $ua))
            $platform = 'Android';
        elseif (preg_match('/linux/i', $ua))
            $platform = 'Linux';
        elseif (preg_match('/macintosh|mac os x/i', $ua))
            $platform = 'Mac OS';
        elseif (preg_match('/iphone/i', $ua))
            $platform = 'iOS';

        if (preg_match('/MSIE/i', $ua) && !preg_match('/Opera/i', $ua))
            $browser = 'Internet Explorer';
        elseif (preg_match('/Firefox/i', $ua))
            $browser = 'Firefox';
        elseif (preg_match('/Chrome/i', $ua))
            $browser = 'Chrome';
        elseif (preg_match('/Safari/i', $ua))
            $browser = 'Safari';
        elseif (preg_match('/Opera/i', $ua))
            $browser = 'Opera';

        return "$platform / $browser";
    }
}

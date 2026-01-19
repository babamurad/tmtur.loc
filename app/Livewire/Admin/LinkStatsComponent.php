<?php

namespace App\Livewire\Admin;

use App\Models\GeneratedLink;
use Livewire\Component;
use Livewire\WithPagination;

class LinkStatsComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $link;
    public $chartData = [];
    public $stats = [];

    public function mount($id)
    {
        $this->link = GeneratedLink::findOrFail($id);

        if (auth()->user()->isReferral() && $this->link->user_id !== auth()->id()) {
            abort(403);
        }

        $this->prepareChartData();
        $this->prepareStats();
    }

    public function prepareChartData()
    {
        $data = $this->link->clicks()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = [];
        $counts = [];

        // Fill in missing dates
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates[] = $date;
            $found = $data->firstWhere('date', $date);
            $counts[] = $found ? $found->count : 0;
        }

        $this->chartData = [
            'labels' => $dates,
            'data' => $counts
        ];
    }

    public function prepareStats()
    {
        $clicks = $this->link->clicks;

        $this->stats['top_browser'] = $clicks->count() > 0 ? $this->getTopMetric($clicks, function ($c) {
            return $this->parseUserAgent($c->user_agent)['browser'];
        }) : 'Нет данных';

        $this->stats['top_os'] = $clicks->count() > 0 ? $this->getTopMetric($clicks, function ($c) {
            return $this->parseUserAgent($c->user_agent)['platform'];
        }) : 'Нет данных';

        $this->stats['top_location'] = $clicks->whereNotNull('location')->count() > 0
            ? $clicks->whereNotNull('location')->groupBy('location')->sortDesc()->keys()->first()
            : 'Нет данных';
    }

    private function getTopMetric($collection, $callback)
    {
        return $collection->map($callback)->countBy()->sortDesc()->keys()->first();
    }

    public function openQrCodeModal()
    {
        $this->dispatch('open-qr-modal');
    }

    public function render()
    {
        return view('livewire.admin.link-stats-component', [
            'clicks' => $this->link->clicks()->latest()->paginate(20)
        ])->layout('layouts.app');
    }

    public function parseUserAgent($ua)
    {
        $platform = 'Unknown OS';
        $browser = 'Unknown Browser';
        $icon = 'bx bx-question-mark';
        $platformIcon = 'bx bx-desktop';

        // Platform
        if (preg_match('/windows|win32/i', $ua)) {
            $platform = 'Windows';
            $platformIcon = 'bx bxl-windows';
        } elseif (preg_match('/android/i', $ua)) {
            $platform = 'Android';
            $platformIcon = 'bx bxl-android';
        } elseif (preg_match('/linux/i', $ua)) {
            $platform = 'Linux';
            $platformIcon = 'bx bxl-tux';
        } elseif (preg_match('/macintosh|mac os x/i', $ua)) {
            $platform = 'Mac OS';
            $platformIcon = 'bx bxl-apple';
        } elseif (preg_match('/iphone/i', $ua)) {
            $platform = 'iOS';
            $platformIcon = 'bx bxl-apple';
        }

        // Browser
        if (preg_match('/MSIE/i', $ua) && !preg_match('/Opera/i', $ua)) {
            $browser = 'Internet Explorer';
            $icon = 'bx bxl-internet-explorer';
        } elseif (preg_match('/Firefox/i', $ua)) {
            $browser = 'Firefox';
            $icon = 'bx bxl-firefox';
        } elseif (preg_match('/Chrome/i', $ua)) {
            $browser = 'Chrome';
            $icon = 'bx bxl-chrome';
        } elseif (preg_match('/Safari/i', $ua)) {
            $browser = 'Safari';
            $icon = 'bx bxs-compass'; // No safari logo in boxicons standard sometimes, alternate
        } elseif (preg_match('/Opera/i', $ua)) {
            $browser = 'Opera';
            $icon = 'bx bxl-opera';
        } elseif (preg_match('/Edg/i', $ua)) {
            $browser = 'Edge';
            $icon = 'bx bxl-edge';
        }

        return [
            'platform' => $platform,
            'browser' => $browser,
            'browser_icon' => $icon,
            'platform_icon' => $platformIcon,
            'string' => "$platform / $browser"
        ];
    }
}

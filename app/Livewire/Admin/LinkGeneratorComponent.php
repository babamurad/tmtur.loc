<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class LinkGeneratorComponent extends Component
{
    public $targetUrl;
    public $source;
    public $result;

    public function mount()
    {
        $this->targetUrl = config('app.url');
        $this->source = '';
    }

    public function updated($fields)
    {
        $this->generate();
    }

    public function generate()
    {
        if (empty($this->targetUrl) || empty($this->source)) {
            $this->result = '';
            return;
        }

        // Basic URL validation/cleaning
        $url = trim($this->targetUrl);
        $source = trim($this->source);
        
        if (empty($source)) {
            $this->result = '';
            return;
        }

        $separator = parse_url($url, PHP_URL_QUERY) ? '&' : '?';
        $this->result = $url . $separator . 'utm_source=' . urlencode($source);
    }

    public function render()
    {
        return view('livewire.admin.link-generator-component')->layout('layouts.app');
    }
}

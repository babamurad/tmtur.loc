<?php

namespace App\Livewire\Front;

use Livewire\Component;

use Livewire\Attributes\Layout;
use Artesaos\SEOTools\Facades\SEOTools;

#[Layout('layouts.front-app', ['hideCarousel' => true])]
class Privacy extends Component
{
    public $page;

    public function mount()
    {
        $this->page = \App\Models\Page::where('slug', 'privacy')->first();

        if ($this->page) {
            SEOTools::setTitle($this->page->tr('title') ?? __('titles.privacy'));
            SEOTools::setDescription(str($this->page->tr('content'))->limit(160));
        } else {
            SEOTools::setTitle(__('titles.privacy'));
        }
    }

    public function render()
    {
        return view('livewire.front.privacy');
    }
}

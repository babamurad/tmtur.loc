<?php

namespace App\Livewire\Admin;

use App\Models\GeneratedLink;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class LinkGeneratorComponent extends Component
{
    use WithPagination;

    public $targetUrl;
    public $source;
    public $result;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'targetUrl' => 'required|url',
        'source' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->targetUrl = config('app.url');
        $this->source = '';
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function generate()
    {
        $this->validate();

        // Basic URL validation/cleaning
        $url = trim($this->targetUrl);
        $source = trim($this->source);

        $separator = parse_url($url, PHP_URL_QUERY) ? '&' : '?';
        $fullUrl = $url . $separator . 'utm_source=' . urlencode($source);
        
        $this->result = $fullUrl;

        // Save to DB
        GeneratedLink::create([
            'target_url' => $url,
            'source' => $source,
            'full_url' => $fullUrl
        ]);

        LivewireAlert::title('Ссылка создана')
            ->text('Ссылка сохранена в истории.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
            
        $this->source = ''; // Clear source input
        $this->resetPage(); 
    }

    public function delete($id)
    {
        GeneratedLink::findOrFail($id)->delete();
        LivewireAlert::title('Удалено')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render()
    {
        return view('livewire.admin.link-generator-component', [
            'links' => GeneratedLink::latest()->paginate(10)
        ])->layout('layouts.app');
    }
}

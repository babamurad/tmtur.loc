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

    public $payoutLink;
    public $payoutAmount;
    public $payoutNotes;

    public function openPayoutModal($id)
    {
        $this->payoutLink = GeneratedLink::findOrFail($id);
        $this->payoutAmount = $this->payoutLink->balance > 0 ? $this->payoutLink->balance : '';
        $this->payoutNotes = '';
        $this->dispatch('open-payout-modal');
    }

    public function savePayout()
    {
        $this->validate([
            'payoutAmount' => 'required|numeric|min:0.01',
            'payoutNotes' => 'nullable|string'
        ]);

        $this->payoutLink->payouts()->create([
            'amount' => $this->payoutAmount,
            'notes' => $this->payoutNotes,
            'paid_at' => now(),
        ]);

        $this->dispatch('close-payout-modal');

        LivewireAlert::title('Выплата сохранена')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();

        $this->reset(['payoutLink', 'payoutAmount', 'payoutNotes']);
    }

    public function render()
    {
        return view('livewire.admin.link-generator-component', [
            'links' => GeneratedLink::latest()->with(['bookings', 'payouts'])->paginate(10)
        ])->layout('layouts.app');
    }
}

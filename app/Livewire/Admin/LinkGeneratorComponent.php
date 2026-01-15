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
    public $selectedUser;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'targetUrl' => 'required|url',
        'source' => 'required|string|max:255',
        'selectedUser' => 'nullable|exists:users,id',
    ];

    public function mount()
    {
        $this->targetUrl = config('app.url');
        $this->source = '';
        $this->selectedUser = auth()->id();

        if (auth()->user()->isReferral()) {
            $lastLink = auth()->user()->generatedLinks()->latest()->first();
            if ($lastLink) {
                return redirect()->route('admin.link-generator.stats', $lastLink->id);
            }
        }
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

        // Determine owner: Admin can select, Referral is always self
        $userId = auth()->user()->isAdmin() && $this->selectedUser
            ? $this->selectedUser
            : auth()->id();

        // Save to DB
        GeneratedLink::create([
            'user_id' => $userId,
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
        $this->dispatch('close-create-modal');
    }

    public function delete($id)
    {
        $link = GeneratedLink::findOrFail($id);

        if (auth()->user()->isReferral() && $link->user_id !== auth()->id()) {
            abort(403);
        }

        $link->delete();
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
        if (auth()->user()->isReferral()) {
            abort(403);
        }

        $this->payoutLink = GeneratedLink::findOrFail($id);
        $this->payoutAmount = $this->payoutLink->balance > 0 ? $this->payoutLink->balance : '';
        $this->payoutNotes = '';
        $this->dispatch('open-payout-modal');
    }

    public function savePayout()
    {
        if (auth()->user()->isReferral()) {
            abort(403);
        }

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

    public $qrCodeLink;

    public function openQrCodeModal($id)
    {
        $link = GeneratedLink::findOrFail($id);

        if (auth()->user()->isReferral() && $link->user_id !== auth()->id()) {
            abort(403);
        }

        $this->qrCodeLink = $link;
        $this->dispatch('open-qr-modal');
    }

    public function render()
    {
        $query = GeneratedLink::query();

        if (auth()->user()->isReferral()) {
            $query->where('user_id', auth()->id());
        }

        $referralUsers = [];
        if (auth()->user()->isAdmin()) {
            $referralUsers = \App\Models\User::where('role', \App\Models\User::ROLE_REFERRAL)->get();
        }

        return view('livewire.admin.link-generator-component', [
            'links' => $query->orderBy('click_count', 'desc')->latest()->with(['bookings', 'payouts'])->paginate(10),
            'referralUsers' => $referralUsers,
        ])->layout('layouts.app');
    }
}

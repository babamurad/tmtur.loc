<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class NewsletterSubscribersCrud extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterStatus = 'all'; // all, active, inactive
    public $delId = null;

    protected $queryString = ['search', 'filterStatus'];
    protected $listeners = ['deleteConfirm'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = \App\Models\NewsletterSubscriber::query();

        if ($this->search) {
            $query->where('email', 'like', '%' . $this->search . '%');
        }

        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        $subscribers = $query->orderBy('subscribed_at', 'desc')->paginate(20);

        return view('livewire.admin.newsletter-subscribers-crud', [
            'subscribers' => $subscribers,
            'totalSubscribers' => \App\Models\NewsletterSubscriber::count(),
            'activeSubscribers' => \App\Models\NewsletterSubscriber::where('is_active', true)->count(),
        ]);
    }

    public function toggleStatus($id)
    {
        $subscriber = \App\Models\NewsletterSubscriber::findOrFail($id);
        $subscriber->update(['is_active' => !$subscriber->is_active]);

        \Jantinnerezo\LivewireAlert\Facades\LivewireAlert::title('Статус обновлен')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function delete($id)
    {
        $this->delId = $id;
        \Jantinnerezo\LivewireAlert\Facades\LivewireAlert::title('Удалить подписчика?')
            ->text('Вы уверены, что хотите удалить этого подписчика?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('deleteConfirm')
            ->show(null, ['backdrop' => true]);
    }

    public function deleteConfirm()
    {
        \App\Models\NewsletterSubscriber::findOrFail($this->delId)->delete();

        \Jantinnerezo\LivewireAlert\Facades\LivewireAlert::title('Подписчик удален')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function exportCsv()
    {
        $query = \App\Models\NewsletterSubscriber::query();

        if ($this->search) {
            $query->where('email', 'like', '%' . $this->search . '%');
        }

        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('is_active', false);
        }

        $subscribers = $query->orderBy('subscribed_at', 'desc')->get();

        $filename = 'newsletter_subscribers_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($subscribers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Email', 'Subscribed At', 'Status', 'IP Address']);

            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->email,
                    $subscriber->subscribed_at ? $subscriber->subscribed_at->format('Y-m-d H:i:s') : '',
                    $subscriber->is_active ? 'Active' : 'Inactive',
                    $subscriber->ip_address ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

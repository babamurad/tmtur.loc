<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;

class ContactMessagesTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortAsc = false;
    public $search = '';

    public $filter = 'active'; // 'active', 'trash'
    public $selected = [];
    public $selectAll = false;

    /* ------------------- действия ------------------- */
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->rows->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function updatedPage()
    {
        $this->selected = [];
        $this->selectAll = false;
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
        $this->selected = [];
        $this->selectAll = false;
    }

    public function deleteSelected()
    {
        ContactMessage::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        $this->dispatch('messagesUpdated');
    }

    public function restoreSelected()
    {
        ContactMessage::onlyTrashed()->whereIn('id', $this->selected)->restore();
        $this->selected = [];
        $this->selectAll = false;
        $this->dispatch('messagesUpdated');
    }

    public function forceDeleteSelected()
    {
        ContactMessage::onlyTrashed()->whereIn('id', $this->selected)->forceDelete();
        $this->selected = [];
        $this->selectAll = false;
        $this->dispatch('messagesUpdated');
    }

    public function markAsRead($id)
    {
        ContactMessage::withTrashed()->where('id', $id)->update(['is_read' => true]);
        $this->dispatch('messagesUpdated'); // для обновления счётчика в шапке
    }

    public function markAsUnread($id)
    {
        ContactMessage::withTrashed()->where('id', $id)->update(['is_read' => false]);
        $this->dispatch('messagesUpdated');
    }

    public function delete($id)
    {
        $message = ContactMessage::find($id);
        if ($message) {
            $message->delete();
            $this->dispatch('messagesUpdated');
        }
    }

    public function restore($id)
    {
        $message = ContactMessage::onlyTrashed()->find($id);
        if ($message) {
            $message->restore();
            $this->dispatch('messagesUpdated');
        }
    }

    public function forceDelete($id)
    {
        $message = ContactMessage::onlyTrashed()->find($id);
        if ($message) {
            $message->forceDelete();
            $this->dispatch('messagesUpdated');
        }
    }

    /* ------------------- запрос ------------------- */
    public function getRowsQueryProperty()
    {
        $query = ContactMessage::query()
            ->when($this->search, fn($q) => $q
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhere('phone', 'like', "%{$this->search}%"))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

        if ($this->filter === 'trash') {
            $query->onlyTrashed();
        }

        return $query;
    }

    public function getTrashCountProperty()
    {
        return ContactMessage::onlyTrashed()->count();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->perPage);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
            $this->sortField = $field;
        }
    }

    /* ------------------- рендер ------------------- */
    public function render()
    {
        return view('livewire.contact-messages-table', [
            'messages' => $this->rows,
        ]);
    }
}

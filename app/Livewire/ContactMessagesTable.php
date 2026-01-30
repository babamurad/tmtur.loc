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

    /* ------------------- действия ------------------- */
    public function markAsRead($id)
    {
        ContactMessage::where('id', $id)->update(['is_read' => true]);
        $this->dispatch('messagesUpdated'); // для обновления счётчика в шапке
    }

    public function markAsUnread($id)
    {
        ContactMessage::where('id', $id)->update(['is_read' => false]);
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

    /* ------------------- запрос ------------------- */
    public function getRowsQueryProperty()
    {
        return ContactMessage::query()
            ->when($this->search, fn($q) => $q
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhere('phone', 'like', "%{$this->search}%"))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
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

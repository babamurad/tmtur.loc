<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class CustomerIndexComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;
    public $delId;

    public function render()
    {
        $customers = Customer::query()
            ->when($this->search, function ($query) {
                $query->where('full_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('passport', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.customers.customer-index-component', [
            'customers' => $customers
        ]);
    }

    public function mount()
    {
        if (session()->has('saved')) {
            LivewireAlert::title(session('saved.title'))
                ->text(session('saved.text'))
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->dispatch('search-cleared');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->resetPage();
        $this->perPage = $value;
    }

    public function delete($id)
    {
        $this->delId = $id;
        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить этого клиента?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('customerDelete')
            ->show();
    }

    public function customerDelete()
    {
        $customer = Customer::findOrFail($this->delId);
        $customer->delete();

        LivewireAlert::title('Клиент удален.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }
}
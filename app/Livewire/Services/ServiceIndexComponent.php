<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\On;


class ServiceIndexComponent extends Component
{
    public $delId;

    protected $listeners = ['delete'];

    public function render()
    {
        $services = Service::orderBy('id', 'desc')->paginate(8);
        return view('livewire.services.service-index-component', [
            'services' => $services,
        ]);
    }

    // #[On('delete')]
    public function delete($id)
    {
        info("Delete record");
        Service::findOrFail($id)->delete();
        session()->flash('success', 'Услуга удалена.');
    }

    public function serviceDelete($id)
    {
        info("Delete: " . $id);
        $this->delId = $id;
        $this->dispatch('confirmDelete', $id);
    }
}

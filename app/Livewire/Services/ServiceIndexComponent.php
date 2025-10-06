<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;



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
        info("Delete: " . $id);
        $this->delId = $id;
        LivewireAlert::title('Удалить?') 
            ->text('Вы уверены, что хотите удалить услугу?')  
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('serviceDelete')
            ->show();

        // Service::findOrFail($id)->delete();
        // session()->flash('success', 'Услуга удалена.');
    }

    public function serviceDelete()
    {
        
        $service = Service::findOrFail($this->delId);
        info("Deleting service: " . $service);
        $service->delete();

        LivewireAlert::title('Услуга удалена.')
        ->success()
        ->toast()
        ->position('top-end')
        ->show();
    }
}


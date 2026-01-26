<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;



class ServiceIndexComponent extends Component
{
    use \Livewire\WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $delId;
    public $perPage = 8;

    public function render()
    {
        $services = Service::orderBy('id', 'desc')->paginate($this->perPage);
        return view('livewire.services.service-index-component', [
            'services' => $services,
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


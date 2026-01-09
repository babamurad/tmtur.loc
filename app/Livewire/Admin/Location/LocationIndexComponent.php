<?php

namespace App\Livewire\Admin\Location;

use App\Models\Location;
use Livewire\Component;
use Livewire\WithPagination;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class LocationIndexComponent extends Component
{
    use WithPagination;

    public $locationId;

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

    protected $listeners = ['confirmDelete'];

    public function delete($id)
    {
        $this->locationId = $id;

        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить эту локацию?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('confirmDelete')
            ->show(null, ['backdrop' => true]);
    }

    public function confirmDelete()
    {
        $location = Location::find($this->locationId);

        if ($location) {
            $location->delete();

            LivewireAlert::title(__('locations.location_deleted'))
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    public function render()
    {
        $locations = Location::paginate(10);
        return view('livewire.admin.location.location-index-component', ['locations' => $locations])->layout('layouts.app');
    }
}

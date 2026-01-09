<?php

namespace App\Livewire\Admin\Place;

use App\Models\Place;
use Livewire\Component;
use Livewire\WithPagination;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class PlaceIndexComponent extends Component
{
    use WithPagination;

    public $placeId;

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
        $this->placeId = $id;

        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить эту достопримечательность?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('confirmDelete')
            ->show(null, ['backdrop' => true]);
    }

    public function confirmDelete()
    {
        $place = Place::find($this->placeId);

        if ($place) {
            $place->delete();

            LivewireAlert::title(__('locations.place_deleted'))
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    public function render()
    {
        $places = Place::paginate(10);
        return view('livewire.admin.place.place-index-component', ['places' => $places])->layout('layouts.app');
    }
}

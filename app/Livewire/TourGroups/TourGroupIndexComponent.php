<?php

namespace App\Livewire\TourGroups;

use App\Models\TourGroup;
use Livewire\Component;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithPagination;

class TourGroupIndexComponent extends Component
{
    use WithPagination;

    public $delId;

    public function render()
    {
        $tourGroups = TourGroup::orderBy('id', 'desc')->paginate(8);
        return view('livewire.tour-groups.tour-group-index-component', [
            'tourGroups' => $tourGroups,
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

    public function delete($id)
    {
        info("Delete: " . $id);
        $this->delId = $id;
        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить группу туров?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('tourGroupDelete')
            ->show();
    }

    public function tourGroupDelete()
    {
        $tourGroup = TourGroup::findOrFail($this->delId);
        info("Deleting tour group: " . $tourGroup);
        $tourGroup->delete();

        LivewireAlert::title('Группа туров удалена.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }
}
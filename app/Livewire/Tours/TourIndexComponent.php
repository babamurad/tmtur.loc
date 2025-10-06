<?php

namespace App\Livewire\Tours;

use App\Models\Tour;
use Livewire\Component;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithPagination;

class TourIndexComponent extends Component
{
    use WithPagination;

    public $delId;

    public function render()
    {
        $tours = Tour::orderBy('id', 'desc')->paginate(8);
        return view('livewire.tours.tour-index-component', [
            'tours' => $tours,
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
            ->text('Вы уверены, что хотите удалить тур?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('tourDelete')
            ->show();
    }

    public function tourDelete()
    {
        $tour = Tour::findOrFail($this->delId);
        info("Deleting tour: " . $tour);
        $tour->delete();

        LivewireAlert::title('Тур удален.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }
}

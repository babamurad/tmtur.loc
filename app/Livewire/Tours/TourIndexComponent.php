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
    public $perPage = 8;
    public $search = '';

    public function render()
    {
        $tours = Tour::with('tourCategory', 'media')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

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

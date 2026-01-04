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
    protected $paginationTheme = 'bootstrap';

    public $delId;
    public $perPage = 10;
    public $search = '';
    public $showTrash = false;

    public $sortColumn = 'id';
    public $sortDirection = 'desc';

    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
            $this->sortColumn = $column;
        }
    }

    public function render()
    {
        $query = TourGroup::query()
            ->select('tour_groups.*') // Explicitly select tour_groups columns
            ->with(['tour']);

        if ($this->showTrash) {
            $query->onlyTrashed();
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('starts_at', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhereHas('tour', function ($sq) {
                        $sq->where('title', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Sorting Logic
        if ($this->sortColumn === 'tour_title') {
            $query->leftJoin('tours', 'tour_groups.tour_id', '=', 'tours.id')
                ->orderBy('tours.title', $this->sortDirection);
        } else {
            $query->orderBy($this->sortColumn, $this->sortDirection);
        }

        $tourGroups = $query->paginate($this->perPage);

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

    public function clearSearch()
    {
        $this->search = '';

        // Опционально: обновить input через JS
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
        info("Delete: " . $id);
        $this->delId = $id;
        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить группу туров?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('tourGroupDelete')
            ->onConfirm('tourGroupDelete')
            ->show();
    }

    public function toggleTrash()
    {
        $this->showTrash = !$this->showTrash;
        $this->resetPage();
    }

    public function restore($id)
    {
        $tourGroup = TourGroup::onlyTrashed()->findOrFail($id);
        $tourGroup->restore();

        LivewireAlert::title('Группа восстановлена.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function forceDelete($id)
    {
        $this->delId = $id;
        LivewireAlert::title('Удалить навсегда?')
            ->text('Это действие необратимо!')
            ->timer(5000)
            ->withConfirmButton('Да, удалить')
            ->withCancelButton('Отмена')
            ->onConfirm('tourGroupForceDelete')
            ->show();
    }

    #[On('tourGroupForceDelete')]
    public function tourGroupForceDelete()
    {
        $tourGroup = TourGroup::onlyTrashed()->findOrFail($this->delId);
        $tourGroup->forceDelete();

        LivewireAlert::title('Группа удалена навсегда.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    #[On('tourGroupDelete')]
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

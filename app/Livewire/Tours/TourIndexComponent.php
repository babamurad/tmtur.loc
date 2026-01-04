<?php

namespace App\Livewire\Tours;

use App\Models\Tour;
use Livewire\Component;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;

class TourIndexComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $delId;
    public $perPage = 12;
    public $search = '';
    public $showTrashed = false;

    protected $listeners = ['tourDelete', 'tourForceDelete'];

    public function render()
    {
        Log::info('TourIndexComponent Render Start', [
            'page' => $this->getPage(),
            'perPage' => $this->perPage,
            'search' => $this->search,
            'showTrashed' => $this->showTrashed,
            'url' => request()->fullUrl(),
        ]);

        try {
            //🐪
            $query = Tour::with('categories', 'media');

            if ($this->showTrashed) {
                $query->onlyTrashed();
            }

            $tours = $query->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('short_description', 'like', '%' . $this->search . '%');
                });
            })
                ->orderBy('id', 'desc')
                ->paginate($this->perPage);

            Log::info('TourIndexComponent Paginator Created', [
                'total' => $tours->total(),
                'currentPage' => $tours->currentPage(),
                'lastPage' => $tours->lastPage(),
            ]);

            return view('livewire.tours.tour-index-component', [
                'tours' => $tours,
            ]);
        } catch (\Exception $e) {
            Log::error('TourIndexComponent Render Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function toggleTrashed()
    {
        $this->showTrashed = !$this->showTrashed;
        $this->resetPage();
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
        $this->delId = $id;

        if ($this->showTrashed) {
            // Force Delete Confirmation
            LivewireAlert::title('Удалить навсегда?')
                ->text('Это действие необратимо!')
                ->timer(5000)
                ->withConfirmButton('Да, удалить')
                ->withCancelButton('Отмена')
                ->onConfirm('tourForceDelete')
                ->show(null, ['backdrop' => true]);
        } else {
            // Soft Delete Confirmation
            LivewireAlert::title('Удалить?')
                ->text('Вы уверены, что хотите удалить тур? Он будет перемещен в корзину.')
                ->timer(5000)
                ->withConfirmButton('Да')
                ->withCancelButton('Отмена')
                ->onConfirm('tourDelete')
                ->show(null, ['backdrop' => true]);
        }
    }

    public function tourDelete()
    {
        $tour = Tour::findOrFail($this->delId);
        $tour->delete();

        LivewireAlert::title('Тур перемещен в корзину.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function tourForceDelete()
    {
        $tour = Tour::withTrashed()->findOrFail($this->delId);
        $tour->forceDelete();

        LivewireAlert::title('Тур удален навсегда.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function restore($id)
    {
        $tour = Tour::withTrashed()->findOrFail($id);
        $tour->restore();

        LivewireAlert::title('Тур восстановлен.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }
}

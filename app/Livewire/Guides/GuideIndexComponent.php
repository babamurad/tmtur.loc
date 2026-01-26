<?php
namespace App\Livewire\Guides;

use App\Models\Guide;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class GuideIndexComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $showTrashed = false;

    protected $listeners = ['destroy', 'forceDestroy'];

    public $search = '';
    public $perPage = 8;
    public $delId;

    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleTrashed()
    {
        $this->showTrashed = !$this->showTrashed;
        $this->resetPage();
    }

    public function mount()
    {
        if (session()->has('success')) {
            LivewireAlert::title(session('success'))
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    public function render()
    {
        $query = Guide::query();

        if ($this->showTrashed) {
            $query->onlyTrashed();
        }

        $guides = $query->when($this->search, function ($q) {
            $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('specialization', 'like', "%{$this->search}%")
                ->orWhereJsonContains('languages', $this->search);
        })
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.guides.guide-index-component', compact('guides'));
    }

    /* ---------- удаление ---------- */
    public function delete($id)
    {
        $this->delId = $id;

        if ($this->showTrashed) {
            LivewireAlert::title('Удалить навсегда?')
                ->text('Это действие необратимо!')
                ->timer(null)
                ->withConfirmButton('Да, удалить')
                ->withCancelButton('Отмена')
                ->onConfirm('forceDestroy')
                ->show();
        } else {
            LivewireAlert::title('Удалить гида?')
                ->text('Гид будет перемещен в корзину.')
                ->timer(null)
                ->withConfirmButton('Да')
                ->withCancelButton('Отмена')
                ->onConfirm('destroy')
                ->show();
        }
    }

    public function destroy()
    {
        $guide = Guide::findOrFail($this->delId);
        $guide->delete();

        LivewireAlert::title('Гид перемещен в корзину')->success()->toast()->position('top-end')->show();
    }

    public function forceDestroy()
    {
        $guide = Guide::withTrashed()->findOrFail($this->delId);

        // удаляем картинку
        if ($guide->image && Storage::disk('public_uploads')->exists($guide->image)) {
            Storage::disk('public_uploads')->delete($guide->image);
        }

        $guide->forceDelete();

        LivewireAlert::title('Гид удален навсегда')->success()->toast()->position('top-end')->show();
    }

    public function restore($id)
    {
        $guide = Guide::withTrashed()->findOrFail($id);
        $guide->restore();

        LivewireAlert::title('Гид восстановлен')->success()->toast()->position('top-end')->show();
    }
}

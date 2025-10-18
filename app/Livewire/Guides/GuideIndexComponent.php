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

    public $search = '';
    public $perPage = 8;
    public $delId;

    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
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
        $guides = Guide::when($this->search, function ($q) {
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
        LivewireAlert::title('Удалить гида?')
            ->timer(null)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('destroy')
            ->show();
    }

    public function destroy()
    {
        $guide = Guide::findOrFail($this->delId);

        // удаляем картинку
        if ($guide->image && Storage::disk('public_uploads')->exists($guide->image)) {
            Storage::disk('public_uploads')->delete($guide->image);
        }

        $guide->delete();

        LivewireAlert::title('Гид удалён')->success()->toast()->position('top-end')->show();
    }
}

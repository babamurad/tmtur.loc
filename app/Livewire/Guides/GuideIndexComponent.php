<?php

namespace App\Livewire\Guides;

use App\Models\Guide;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class GuideIndexComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $queryString = ['search' => ['except' => '']];

    public function deleteGuide($id)
    {
        Guide::findOrFail($id)->delete();
        session()->flash('success', 'Гид удалён.');
    }

    public function mount()
    {
        if (session()->has('error')) {
            LivewireAlert::title(session('saved.title'))
                ->text(session('saved.text'))
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';

        $guides = Guide::with('media')
            ->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('specialization', 'like', $searchTerm)
                    ->orWhere('languages', 'like', '%"' . $this->search . '"%');
            })
            ->ordered()
            ->paginate($this->perPage);

        return view('livewire.guides.guide-index-component', compact('guides'));
    }
}

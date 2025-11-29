<?php

namespace App\Livewire\Inclusions;

use App\Models\Inclusion;
use Livewire\Component;
use Livewire\WithPagination;

class InclusionIndexComponent extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $inclusion = Inclusion::findOrFail($id);
        $inclusion->delete();
        session()->flash('message', 'Включение успешно удалено.');
    }

    public function render()
    {
        $inclusions = Inclusion::paginate(10);
        return view('livewire.inclusions.inclusion-index-component', [
            'inclusions' => $inclusions
        ]);
    }
}

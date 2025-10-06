<?php

namespace App\Livewire\TourGroups;

use App\Models\TourGroup;
use Livewire\Component;

class TourGroupCreateComponent extends Component
{
    public $name;
    public $description;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'description' => 'nullable',
        ];
    }

    public function render()
    {
        return view('livewire.tour-groups.tour-group-create-component');
    }

    public function save()
    {
        $this->validate();

        TourGroup::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('saved', [
            'title' => 'Группа туров создана!',
            'text' => 'Создана новая группа туров!',
        ]);
        return redirect()->route('tour-groups.index');
    }
}
<?php

namespace App\Livewire\TourGroups;

use App\Models\TourGroup;
use Livewire\Component;

class TourGroupEditComponent extends Component
{
    public $tourGroup;
    public $name;
    public $description;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'description' => 'nullable',
        ];
    }

    public function mount(TourGroup $tourGroup)
    {
        $this->tourGroup = $tourGroup;
        $this->name = $tourGroup->name;
        $this->description = $tourGroup->description;
    }

    public function render()
    {
        return view('livewire.tour-groups.tour-group-edit-component');
    }

    public function save()
    {
        $this->validate();

        $this->tourGroup->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('saved', [
            'title' => 'Группа туров сохранена!',
            'text' => 'Изменения сохранились!',
        ]);
        return redirect()->route('tour-groups.index');
    }
}
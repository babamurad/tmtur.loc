<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;

class ServiceEditComponent extends Component
{
    public $service;
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'required',
    ];

    public function mount($id)
    {
        $this->service = Service::find($id);
        $this->name = $this->service->name;
        $this->description = $this->service->description;
    }

    public function render()
    {
        return view('livewire.services.service-edit-component');
    }

    public function update()
    {
        $this->validate();

        $this->service->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        return redirect()->route('services.index');
    }
}

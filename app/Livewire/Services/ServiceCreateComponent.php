<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;

class ServiceCreateComponent extends Component
{
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'required',
    ];

    public function render()
    {
        return view('livewire.services.service-create-component');
    }

    public function save()
    {
        $this->validate();

        Service::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        return redirect()->route('services.index');
    }
}

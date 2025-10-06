<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use App\Enums\ServiceType;

class ServiceCreateComponent extends Component
{
    public $name;
    public $type;
    public $priceRub;       

    protected function rules()
    {
        return [
            'name'     => 'required|min:3|max:255',
            'type'     => 'required|in:' . ServiceType::ruleIn(),
            'priceRub' => 'required|numeric|min:0.01',
        ];
    }

    public function render()
    {
        return view('livewire.services.service-create-component');
    }

    public function save()
    {
        $this->validate();

        Service::create([
            'name'                => $this->name,
            'type'                => $this->type,
            'default_price_cents' => (int) round($this->priceRub * 100),
        ]);

        session()->flash('success', 'Service created successfully.');
        return redirect()->route('services.index');
    }
}
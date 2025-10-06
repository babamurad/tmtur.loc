<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use App\Enums\ServiceType;

class ServiceEditComponent extends Component
{
    public $service;
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

    public function mount(Service $service)
    {
        $this->service = $service;
        $this->name = $service->name;
        $this->type = $service->type;
        $this->priceRub = $service->default_price_cents / 100;
    }

    public function render()
    {
        return view('livewire.services.service-edit-component');
    }

    public function save()
    {
        $this->validate();

        $this->service->update([
            'name'                => $this->name,
            'type'                => $this->type,
            'default_price_cents' => (int) round($this->priceRub * 100),
        ]);

        session()->flash('success', 'Service updated successfully.');
        return redirect()->route('services.index');
    }
}

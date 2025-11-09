<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use App\Enums\ServiceType;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

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
            'priceRub' => '|numeric|nullable',
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
            'default_price_cents' => $this->priceRub ? (int) round($this->priceRub * 100) : 0,
        ]);

        session()->flash('saved', [
        'title' => 'Услуга сохранена!',
        'text' => 'Изменения сохранились!',
        ]);
        return redirect()->route('services.index');
    }
}

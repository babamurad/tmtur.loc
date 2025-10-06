<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;


class ServiceIndexComponent extends Component
{
    public function render()
    {
        $services = Service::paginate(5);
        return view('livewire.services.service-index-component', [
            'services' => $services,
        ]);
    }

    public function delete($id)
    {
        Service::find($id)->delete();
    }
}

<?php

namespace App\Livewire\Admin\Routes;

use App\Models\Route;
use Livewire\Component;
use Livewire\WithPagination;

class RouteIndexComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function delete($id)
    {
        $route = Route::find($id);
        if ($route) {
            $route->delete();
            $this->dispatch('alert', ['type' => 'success', 'message' => 'Маршрут удален']);
        }
    }

    public function render()
    {
        $query = Route::query();

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhereHas('location', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
        }

        $routes = $query->with('days.location')->orderBy('sort_order', 'asc')->paginate(10);

        return view('livewire.admin.routes.route-index-component', compact('routes'))
            ->layout('layouts.app');
    }
}

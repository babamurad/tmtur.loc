<?php

namespace App\Livewire\Admin\Routes;

use App\Models\Route;
use Livewire\Component;
use Livewire\WithPagination;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class RouteIndexComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $routeId;

    protected $listeners = ['confirmDelete'];

    public function delete($id)
    {
        $this->routeId = $id;

        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить этот маршрут?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('confirmDelete')
            ->show(null, ['backdrop' => true]);
    }

    public function confirmDelete()
    {
        $route = Route::find($this->routeId);

        if ($route) {
            $route->delete();

            LivewireAlert::title('Маршрут удален')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
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

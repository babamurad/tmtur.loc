<?php

namespace App\Livewire\Users;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\User;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class UserIndexComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            LivewireAlert::title('Ошибка')
                ->text('Нельзя удалить самого себя!')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            return;
        }

        $user->delete();

        LivewireAlert::title('Удалено')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render()
    {
        $users = User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.users.user-index-component', [
            'users' => $users
        ])->layout('layouts.app');
    }
}

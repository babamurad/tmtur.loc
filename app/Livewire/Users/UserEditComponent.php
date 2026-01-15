<?php

namespace App\Livewire\Users;

use Livewire\Component;

use App\Models\User;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class UserEditComponent extends Component
{
    public $user_id;
    public $name;
    public $email;
    public $role;

    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            'role' => 'required|string|in:' . implode(',', [User::ROLE_ADMIN, User::ROLE_MANAGER, User::ROLE_USER, User::ROLE_REFERRAL]),
        ];
    }

    public function save()
    {
        $this->validate();

        $user = User::findOrFail($this->user_id);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        LivewireAlert::title('Сохранено')
            ->text('Данные пользователя обновлены')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.user-edit-component')->layout('layouts.app');
    }
}

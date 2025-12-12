<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class UserProfileDropdown extends Component
{
    public $name;
    public $avatarUrl;

    public function mount()
    {
        $this->loadUserData();
    }

    #[On('profile-updated')]
    public function refreshProfile()
    {
        $this->loadUserData();
    }

    protected function loadUserData()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->avatarUrl = $user->avatar
            ? $user->avatar->url
            : asset('assets/images/users/avatar-1.jpg');
    }

    public function render()
    {
        return view('livewire.user-profile-dropdown');
    }
}

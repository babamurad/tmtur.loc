<?php

namespace App\Livewire\Front;

use App\Models\TourCategory;
use Livewire\Component;

use Livewire\Attributes\On;

class NavbarComponent extends Component
{
    public $cartCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    #[On('cartUpdated')]
    public function updateCartCount() 
    {
        $this->cartCount = count(session('cart', []));
    }

    public function render()
    {
         $categories = TourCategory::where('is_published', 1)->get();
         
        return view('livewire.front.navbar-component',
        ['categories' => $categories]
        );
    }
}

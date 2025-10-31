<?php

namespace App\Livewire\Front;

use Livewire\Component;

class CartWidget extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function render()
    {
        $items = collect(session('cart', []));
        return view('livewire.front.cart-widget', [
            'count' => $items->count(),
            'total' => 0, // можно посчитать
        ])->layout('layouts.front-app');
    }
}

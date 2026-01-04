<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class BookingIndexComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $bookings = Booking::with(['customer', 'tourGroup', 'tourGroup.tour'])
            ->when($this->search, function ($query) {
                $query->whereHas('customer', function($q) {
                    $q->where('full_name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
                })
                ->orWhere('id', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.bookings.booking-index-component', [
            'bookings' => $bookings
        ])->layout('layouts.app');
    }
}
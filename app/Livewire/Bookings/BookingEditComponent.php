<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class BookingEditComponent extends Component
{
    // Removed use LivewireAlert;

    public $booking_id;
    public $status;
    public $notes;
    
    // Read-only data for display
    public $booking_data;

    public function mount($id)
    {
        $this->booking_id = $id;
        $booking = Booking::with(['customer', 'tourGroup', 'tourGroup.tour', 'bookingServices.service'])->findOrFail($id);
        
        $this->status = $booking->status;
        $this->notes = $booking->notes;
        $this->booking_data = $booking;
    }

    public function update()
    {
        $booking = Booking::findOrFail($this->booking_id);
        
        $booking->status = $this->status;
        $booking->notes = $this->notes;
        
        // Handle status-specific logic (e.g. timestamps)
        if ($this->status === 'confirmed' && !$booking->confirmed_at) {
            $booking->confirmed_at = now();
        }
        if ($this->status === 'cancelled' && !$booking->cancelled_at) {
            $booking->cancelled_at = now();
        }

        $booking->save();

        LivewireAlert::title('Бронирование обновлено')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render()
    {
        return view('livewire.bookings.booking-edit-component')->layout('layouts.app');
    }
}
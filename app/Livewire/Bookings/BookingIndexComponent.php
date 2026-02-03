<?php

namespace App\Livewire\Bookings;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class BookingIndexComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 10;
    public $delId;

    public $visibleColumns = [
        'id' => true,
        'customer' => true,
        'tour' => true,
        'created_at' => true,
        'amount' => true,
        'status' => true,
        'source' => true,
        'people_count' => false,
        'starts_at' => false,
        'accommodation' => false,
        'notes' => false,
    ];

    public function mount()
    {
        // Load from session or use default
        if (session()->has('booking_visible_columns')) {
            $this->visibleColumns = array_merge($this->visibleColumns, session('booking_visible_columns'));
        }
    }

    public function updatedVisibleColumns()
    {
        session()->put('booking_visible_columns', $this->visibleColumns);
    }

    protected $listeners = ['bookingDelete'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        session()->flash('message', 'Бронирование отменено.');
    }

    public function blockUser($email)
    {
        if (empty($email)) {
            return;
        }

        \App\Models\BlockedUser::firstOrCreate(
            ['email' => $email],
            ['reason' => 'Blocked via Admin Panel']
        );

        session()->flash('message', "Пользователь {$email} заблокирован.");
    }



    public function unblockUser($email)
    {
        if (empty($email))
            return;

        \App\Models\BlockedUser::where('email', $email)->delete();
        session()->flash('message', "Пользователь {$email} разблокирован.");
    }

    public function deleteBooking($id)
    {
        $this->delId = $id;

        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить это бронирование?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('bookingDelete')
            ->show(null, ['backdrop' => true]);
    }

    public function bookingDelete()
    {
        $booking = Booking::findOrFail($this->delId);
        $booking->delete();

        LivewireAlert::title('Бронирование удалено.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render()
    {
        $bookings = Booking::with(['customer', 'tourGroup', 'tourGroup.tour'])
            ->when($this->search, function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('full_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('id', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        $blockedEmails = \App\Models\BlockedUser::pluck('email')->toArray();

        return view('livewire.bookings.booking-index-component', [
            'bookings' => $bookings,
            'blockedEmails' => $blockedEmails,
        ])->layout('layouts.app');
    }
}
<?php

namespace App\Livewire\Admin\Hotel;

use App\Models\Hotel;
use Livewire\Component;
use Livewire\WithPagination;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class HotelIndexComponent extends Component
{
    use WithPagination;

    public $hotelId;

    public function mount()
    {
        if (session()->has('saved')) {
            \Illuminate\Support\Facades\Log::info('HotelIndexComponent: Session found', session('saved'));
            LivewireAlert::title(session('saved.title'))
                ->text(session('saved.text'))
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        } else {
            \Illuminate\Support\Facades\Log::info('HotelIndexComponent: No session saved key found');
        }
    }

    protected $listeners = ['confirmDelete'];

    public function delete($id)
    {
        $this->hotelId = $id;

        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить этот отель?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('confirmDelete')
            ->show(null, ['backdrop' => true]);
    }

    public function confirmDelete()
    {
        $hotel = Hotel::find($this->hotelId);

        if ($hotel) {
            $hotel->delete();

            LivewireAlert::title(__('locations.hotel_deleted'))
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    public function render()
    {
        $hotels = Hotel::paginate(10);
        return view('livewire.admin.hotel.hotel-index-component', ['hotels' => $hotels])->layout('layouts.app');
    }
}

<?php

namespace App\Livewire\Front;

use Livewire\Component;

class CartComponent extends Component
{
    public function checkout()
    {
        $cart = session('cart', []);
        if(empty($cart)) return;

        DB::transaction(function () use (&$bookingIds) {
            foreach ($cart as $row) {
                $group = TourGroup::findOrFail($row['tour_group_id']);

                if($group->freePlaces() < $row['people']) {
                    throw new \Exception('Недостаточно мест для группы '.$group->id);
                }

                $total = $group->price_cents * $row['people'];

                // суммируем выбранные услуги
                $services = TourGroupService::where('tour_group_id', $group->id)
                    ->whereIn('service_id', $row['services'])
                    ->get();
                foreach ($services as $s) $total += $s->price_cents * $row['people'];

                $booking = Booking::create([
                    'tour_group_id'   => $group->id,
                    'customer_id'     => auth()->id(), // ← залогиненный пользователь
                    'people_count'    => $row['people'],
                    'total_price_cents'=> $total,
                    'status'          => 'pending',
                ]);

                foreach ($services as $s) {
                    BookingService::create([
                        'booking_id' => $booking->id,
                        'service_id' => $s->service_id,
                    ]);
                }
                $bookingIds[] = $booking->id;
            }
        });

        session()->forget('cart');
        return redirect()->route('payment.form', ['ids' => implode(',', $bookingIds)]);
    }

    public function render()
    {
        return view('livewire.front.cart-component', [
            'rows' => collect(session('cart', [])),
        ])
            ->layout('layouts.front-app')
            ->title(__('titles.cart'));
    }
}

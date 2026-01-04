<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\TourGroup;
use App\Models\TourGroupService;
use App\Models\Booking;
use App\Models\BookingService;

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

                // Price is in dollars, convert to cents for total
                $pricePerPersonCents = $group->getPriceForPeople($row['people']) * 100;
                $total = $pricePerPersonCents * $row['people'];

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
                    'referer'         => app(\Spatie\Referer\Referer::class)->get(),
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
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.cart'));
    }
}

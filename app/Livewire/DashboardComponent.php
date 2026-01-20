<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\Tour;
use App\Models\TourGroup;
use Livewire\Component;

class DashboardComponent extends Component
{
    public function render()
    {
        $toursCount = Tour::count();
        $tourGroupsCount = TourGroup::count();
        $bookingsCount = Booking::count();
        $subscribersCount = NewsletterSubscriber::count();

        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentBookings = Booking::with(['customer', 'tourGroup.tour'])->latest()->take(8)->get();

        return view('livewire.dashboard-component', compact(
            'toursCount',
            'tourGroupsCount',
            'bookingsCount',
            'subscribersCount',
            'recentMessages',
            'recentBookings'
        ));
    }
}

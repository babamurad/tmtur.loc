<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\TourItineraryDay;
use Illuminate\Database\Seeder;

class TourItineraryDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tour = Tour::where('slug', '5-day-tour-farab-merv-turkmenbashi-yangikala-darvaza-ashgabat-introduction')->first();

        if ($tour) {
            TourItineraryDay::create([
                'tour_id' => $tour->id,
                'day_number' => 1,
                'title' => 'Day 1: Farab – Ashgabat',
                'description' => '- Meet at the Farab border crossing point.
- Transfer from Farab to Merv.
- Sightseeing in Merv.
- Transfer to Ashgabat.
- Check-in at Ashgabat hotel.
- Overnight in Ashgabat.',
            ]);

            TourItineraryDay::create([
                'tour_id' => $tour->id,
                'day_number' => 2,
                'title' => 'Day 2: Ashgabat – Kov-Ata – Nokhur Village – Turkmenbashi',
                'description' => '- Breakfast at the hotel.
- Depart for Turkmenbashi.
- Visit Kov-Ata underground lake.
- Proceed to Nokhur Village.
- Transfer to Turkmenbashi.
- Check-in at Turkmenbashi hotel.
- Overnight in Turkmenbashi.',
            ]);

            TourItineraryDay::create([
                'tour_id' => $tour->id,
                'day_number' => 3,
                'title' => 'Day 3: Turkmenbashi – Yangikala Canyon – Balkanabat – Ashgabat',
                'description' => '- Breakfast at the hotel.
- Transfer to Yangikala Canyon.
- Explore Yangikala Canyon.
- Transfer from Yangikala to Balkanabat.
- Transfer from Balkanabat to Ashgabat.
- Check-in at Ashgabat hotel.
- Overnight in Ashgabat.',
            ]);

            TourItineraryDay::create([
                'tour_id' => $tour->id,
                'day_number' => 4,
                'title' => 'Day 4: Ashgabat – Darvaza Gas Crater',
                'description' => '- Breakfast at the hotel.
- Ashgabat city tour.
- Transfer to Darvaza Gas Crater.
- Arrive at Darvaza Gas Crater before sunset.
- Dinner at a nearby yurt camp.
- Spend time at the burning crater.
- Overnight at Darvaza in a yurt or tent.',
            ]);

            TourItineraryDay::create([
                'tour_id' => $tour->id,
                'day_number' => 5,
                'title' => 'Day 5: Darvaza – Ashgabat',
                'description' => '- Breakfast at Darvaza.
- Start the return journey to Ashgabat.
- Arrive in Ashgabat around noon.
- Spend some time in Ashgabat.
- Overnight in Ashgabat.
- Transfer to the international airport at night and depart from Turkmenistan.',
            ]);
        }
    }
}

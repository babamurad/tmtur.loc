<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\TourAccommodation;
use Illuminate\Database\Seeder;

class TourAccommodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tour = Tour::where('slug', '5-day-tour-farab-merv-turkmenbashi-yangikala-darvaza-ashgabat-introduction')->first();

        if ($tour) {
            TourAccommodation::create([
                'tour_id' => $tour->id,
                'location' => 'Ashgabat',
                'nights_count' => 3,
                'standard_options' => 'Bagt Kosgi / Mizan / Sport / Ashgabat',
                'comfort_options' => 'Archabil / Yyldyz / Oguzkent',
            ]);

            TourAccommodation::create([
                'tour_id' => $tour->id,
                'location' => 'Darvaza',
                'nights_count' => 1,
                'standard_options' => 'Shared yurts / individual accommodation in yurts or tents available upon request',
                'comfort_options' => null, // или 'Tents available upon request'
            ]);

            TourAccommodation::create([
                'tour_id' => $tour->id,
                'location' => 'Turkmenbashy',
                'nights_count' => 1,
                'standard_options' => 'Beyik Yupek yoly / Nebitchi',
                'comfort_options' => 'Carlak Hotel',
            ]);
        }
    }
}

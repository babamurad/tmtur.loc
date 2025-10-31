<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\TourInclusion;
use Illuminate\Database\Seeder;

class TourInclusionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tour = Tour::where('slug', '5-day-tour-farab-merv-turkmenbashi-yangikala-darvaza-ashgabat-introduction')->first();

        if ($tour) {
            // Включения
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'included',
                'item' => 'Invitation letter support and Foreigner registration in Turkmenistan.',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'included',
                'item' => 'Accommodation. Standart rooms.',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'included',
                'item' => 'Ashgabat City tour',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'included',
                'item' => 'Transport and guide.',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'included',
                'item' => 'Meals at Darvaza and yurt night stay at Darvaza.',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'included',
                'item' => 'All breakfasts',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'included',
                'item' => 'All the expenses of the driver/guide, including gasoline, meals and accommodation, transfer to the point of meeting at border, and separating with the guest at the border.',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'included',
                'item' => 'All taxes',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'included',
                'item' => 'The tour starts at the Turkmenistan border and ends at the Turkmenistan border.',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'included',
                'item' => 'You will see everything that is possible to see within that time. The tour can be changed on the go as possible.',
            ]);

            // Невключения
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'not_included',
                'item' => 'Visa and other fees at the border. (Usually costs not more than $110, per person)',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'not_included',
                'item' => 'Meals ($3-8/ 1meal/ 1person)',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'not_included',
                'item' => 'Entrance fees to Museums and others as per the tour. roughly not more 10$ per day if any.',
            ]);
            TourInclusion::create([
                'tour_id' => $tour->id,
                'type' => 'not_included',
                'item' => 'Tips. Tips are welcomed',
            ]);
        }
    }
}

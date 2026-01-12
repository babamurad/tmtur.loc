<?php

namespace App\Actions\Tour;

use App\Models\Inclusion;
use App\Models\Media;
use App\Models\Tour;
use App\Models\TourAccommodation;
use App\Models\TourItineraryDay;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateTourAction
{
    public function __construct(protected ImageService $imageService)
    {
    }

    /**
     * @param array $data
     * @param array $images
     * @param array $trans
     * @param array $itineraryDays
     * @param array $inclusions
     * @param array $accommodations
     * @param array $categories
     * @param array $tags
     * @return Tour
     */
    public function execute(
        array $data,
        array $images,
        array $trans,
        array $itineraryDays,
        array $inclusions,
        array $accommodations,
        array $categories,
        array $tags = []
    ): Tour {
        return DB::transaction(function () use ($data, $images, $trans, $itineraryDays, $inclusions, $accommodations, $categories, $tags) {
            $fallbackLocale = config('app.fallback_locale');

            // 1. Create Tour
            $tour = Tour::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'is_published' => $data['is_published'] ?? false,
                'base_price_cents' => $data['base_price_cents'] ?? 0,
                'duration_days' => $data['duration_days'] ?? 1,
                'short_description' => $trans[$fallbackLocale]['short_description'] ?? '',
            ]);

            // 2. SEO
            if (!empty($data['seo_title']) || !empty($data['seo_description'])) {
                $tour->seo()->create([
                    'title' => $data['seo_title'] ?? null,
                    'description' => $data['seo_description'] ?? null,
                ]);
            }

            // 3. Translations
            $trans[$fallbackLocale]['title'] = $data['title'];
            foreach ($trans as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    if ($value !== null && $value !== '') {
                        $tour->setTr($field, $locale, $value);
                    }
                }
            }

            // 4. Categories & Tags
            $tour->categories()->sync($categories);
            if (!empty($tags)) {
                $tour->tags()->sync($tags);
            }

            // 5. Itinerary Days
            foreach ($itineraryDays as $dayData) {
                $day = TourItineraryDay::create([
                    'tour_id' => $tour->id,
                    'day_number' => $dayData['day_number'],
                    'title' => $dayData['trans'][$fallbackLocale]['title'] ?? '',
                    'description' => $dayData['trans'][$fallbackLocale]['description'] ?? '',
                    'location_id' => $dayData['location_id'] ?? null,
                ]);

                if (!empty($dayData['place_ids'])) {
                    $day->places()->sync($dayData['place_ids']);
                }
                if (!empty($dayData['hotel_ids'])) {
                    $day->hotels()->sync($dayData['hotel_ids']);
                }

                foreach ($dayData['trans'] as $locale => $fields) {
                    foreach ($fields as $field => $value) {
                        if ($value !== null && $value !== '') {
                            $day->setTr($field, $locale, $value);
                        }
                    }
                }
            }

            // 6. Inclusions
            $syncData = [];
            foreach ($inclusions as $incData) {
                if (!empty($incData['inclusion_id'])) {
                    $syncData[$incData['inclusion_id']] = ['is_included' => $incData['is_included']];
                }
            }
            $tour->inclusions()->sync($syncData);

            // 7. Accommodations
            foreach ($accommodations as $accData) {
                TourAccommodation::create([
                    'tour_id' => $tour->id,
                    'nights_count' => $accData['nights_count'],
                    'location_id' => $accData['location_id'] ?? null,
                    'hotel_standard_id' => $accData['hotel_standard_id'] ?? null,
                    'hotel_comfort_id' => $accData['hotel_comfort_id'] ?? null,
                ]);
            }

            // 8. Images
            if (!empty($images)) {
                foreach ($images as $idx => $file) {
                    $optimized = $this->imageService->saveOptimized($file, 'tours/' . $tour->id);

                    Media::create([
                        'model_type' => Tour::class,
                        'model_id' => $tour->id,
                        'file_path' => $optimized['path'],
                        'file_name' => $optimized['file_name'],
                        'mime_type' => $optimized['mime_type'],
                        'size' => $optimized['size'],
                        'order' => $idx,
                    ]);
                }
            }

            return $tour;
        });
    }
}

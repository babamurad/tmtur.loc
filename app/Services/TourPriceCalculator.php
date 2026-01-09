<?php

namespace App\Services;

use App\Models\Tour;
use App\Models\TourAccommodation;
use Illuminate\Support\Collection;

class TourPriceCalculator
{
    /**
     * @param Tour $tour
     * @param int $minPeople
     * @param int $maxPeople
     * @return array
     */
    public function calculateMatrix(Tour $tour, int $minPeople = 1, int $maxPeople = 15): array
    {
        $matrix = [];
        // Рассчитываем стоимость для каждого количества человек
        for ($peopleCount = $minPeople; $peopleCount <= $maxPeople; $peopleCount++) {
            $matrix[$peopleCount] = [
                'standard' => $this->calculatePriceForPeople($tour, $peopleCount, 'standard'),
                'comfort' => $this->calculatePriceForPeople($tour, $peopleCount, 'comfort'),
            ];
        }

        return $this->optimizeMatrix($matrix);
    }

    /**
     * @param Tour $tour
     * @param int $peopleCount
     * @param string $accommodationType 'standard' | 'comfort'
     * @return array ['price_cents' => int, 'single_supplement_cents' => int]
     */
    public function calculatePriceForPeople(Tour $tour, int $peopleCount, string $accommodationType): array
    {
        // 1. Базовые расходы (Фиксированные делим на кол-во людей)
        $costTransportPerPerson = $tour->cost_transport_cents / $peopleCount;
        $costGuidePerPerson = $tour->cost_guide_cents / $peopleCount;

        // 2. Переменные расходы (на человека)
        // Билеты в музеи/места
        // Проходимся по всем дням и местам в них
        $costPlaces = 0;
        foreach ($tour->itineraryDays as $day) {
            foreach ($day->places as $place) {
                // Предполагаем, что cost в Place в обычных единицах (не центах), поэтому * 100
                // Если cost null, считаем 0
                $costPlaces += ($place->cost ?? 0) * 100;
            }
        }

        // Еда
        $costMeals = $tour->cost_meal_per_day_cents * $tour->duration_days;

        // Итого база (без отелей)
        $baseConstPerPerson = $costTransportPerPerson + $costGuidePerPerson + $costPlaces + $costMeals;

        // 3. Расходы на проживание
        $costAccommodation = 0;
        $costSingleSupplement = 0; // Доплата за одноместное (за весь тур)

        foreach ($tour->accommodations as $accommodation) {
            $hotel = null;
            if ($accommodationType === 'comfort') {
                $hotel = $accommodation->hotelComfort ?? $accommodation->hotel; // Фолбек на обычный, если комфорт не задан? 
            } else {
                $hotel = $accommodation->hotelStandard ?? $accommodation->hotel;
            }

            if ($hotel && $hotel->price) {
                // Цена отеля за ночь.
                // Обычно цена за номер. 
                // При группе > 1 считаем размещение DBL (1/2 номера)
                // При 1 человеке - SGL (полная)

                // Положим логику:
                // Цена в базе (hotel->price) - это цена за НОМЕР (Standard room).
                // Стоимость 1/2 DBL = price / 2.
                // Стоимость SGL = price.

                $pricePerHight = $hotel->price * 100; // в центы

                if ($peopleCount === 1) {
                    $costAccommodation += $pricePerHight * $accommodation->nights_count;
                } else {
                    $costAccommodation += ($pricePerHight / 2) * $accommodation->nights_count;
                    // Доплата за Single, если кто-то захочет в группе жить один
                    // Это разница между SGL (целый номер) и 1/2 DBL (половина)
                    // SGL - 1/2 DBL = price - price/2 = price/2
                    $costSingleSupplement += ($pricePerHight / 2) * $accommodation->nights_count;
                }
            }
        }

        // Добавляем маржу
        $totalCost = $baseConstPerPerson + $costAccommodation;
        $marginMultiplier = 1 + ($tour->company_margin_percent / 100);

        $finalPrice = $totalCost * $marginMultiplier;

        // Single supplement тоже должен быть с маржой
        $finalSingleSupplement = $costSingleSupplement * $marginMultiplier;

        return [
            'price_cents' => (int) round($finalPrice),
            'single_supplement_cents' => (int) round($finalSingleSupplement),
        ];
    }

    /**
     * Группирует одинаковые цены в диапазоны (1 чел, 2-3 чел, и т.д.)
     */
    private function optimizeMatrix(array $matrix): array
    {
        // Пока возвращаем как есть, оптимизацию (группировку 2-4 чел) можно сделать
        // на этапе сохранения или отображения.
        // Для простоты UI пока оставим плоский список от 1 до 10+.
        return $matrix;
    }
}

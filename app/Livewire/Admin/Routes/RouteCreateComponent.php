<?php

namespace App\Livewire\Admin\Routes;

use App\Models\Route;
use App\Models\RouteDay;
use App\Models\Location;
use Livewire\Component;

class RouteCreateComponent extends Component
{
    public $title;
    public $description;
    public $is_active = true;
    public $sort_order = 0;

    // Array of day steps
    public $days = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'days.*.day_number' => 'required|integer',
        'days.*.location_id' => 'required|exists:locations,id',
        'days.*.title' => 'nullable|string',
        'days.*.description' => 'required|string',
        'days.*.place_ids' => 'nullable|array',
        'days.*.hotel_ids' => 'nullable|array',
    ];

    public function mount()
    {
        // Initialize with one empty day
        $this->addDay();
    }

    public function addDay($sameDay = false)
    {
        $dayNumber = 1;
        if (!empty($this->days)) {
            $lastDay = end($this->days);
            $dayNumber = $sameDay ? $lastDay['day_number'] : $lastDay['day_number'] + 1;
        }

        $this->days[] = [
            'day_number' => $dayNumber,
            'location_id' => null,
            'title' => '',
            'description' => '',
            'place_ids' => [],
            'hotel_ids' => [],
        ];
    }

    public function removeDay($index)
    {
        unset($this->days[$index]);
        $this->days = array_values($this->days);
        $this->normalizeDayNumbers();
    }

    public function normalizeDayNumbers()
    {
        if (empty($this->days)) {
            return;
        }

        $normalized = [];
        $lastDayNum = null;
        $currentDay = 1;

        foreach ($this->days as $i => $day) {
            $thisDayNum = (int) $day['day_number'];

            if ($i === 0) {
                // First item is always Day 1
                $currentDay = 1;
            } else {
                // If original day number increased, increment current counter
                // We check against the LAST PROCESSED item's ORIGINAL day number relative to this one?
                // Actually, simply checking if $thisDayNum > $lastDayNum is reliable provided list is sorted.
                if ($thisDayNum > $lastDayNum) {
                    $currentDay++;
                }
            }

            $this->days[$i]['day_number'] = $currentDay;
            $lastDayNum = $thisDayNum;
        }
    }

    public function save()
    {
        $this->normalizeDayNumbers();
        $this->validate();

        $route = Route::create([
            'title' => $this->title,
            'description' => $this->description,
            'activities' => '',
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ]);

        foreach ($this->days as $dayData) {
            $day = $route->days()->create([
                'day_number' => $dayData['day_number'],
                'location_id' => $dayData['location_id'],
                'title' => $dayData['title'],
                'description' => $dayData['description'],
            ]);

            if (!empty($dayData['place_ids'])) {
                $day->places()->sync($dayData['place_ids']);
            }
            if (!empty($dayData['hotel_ids'])) {
                $day->hotels()->sync($dayData['hotel_ids']);
            }
        }

        session()->flash('saved', [
            'title' => 'Маршрут создан!',
            'text' => 'Маршрут успешно добавлен в программу.',
        ]);
        return redirect()->route('admin.routes.index');
    }

    public function render()
    {
        $locations = Location::with(['places', 'hotels'])->orderBy('name')->get();
        return view('livewire.admin.routes.route-create-component', compact('locations'))
            ->layout('layouts.app');
    }
}

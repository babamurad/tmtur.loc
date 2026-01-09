<?php

namespace App\Livewire\Admin\Routes;

use App\Models\Route;
use App\Models\Location;
use Livewire\Component;

class RouteEditComponent extends Component
{
    public $route_id;
    public $title;
    public $description;
    public $is_active;
    public $sort_order;

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
        'days.*.description' => 'nullable|string',
        'days.*.place_ids' => 'nullable|array',
        'days.*.hotel_ids' => 'nullable|array',
    ];

    public function mount($id)
    {
        $route = Route::with(['days.places', 'days.hotels'])->findOrFail($id);
        $this->route_id = $route->id;
        $this->title = $route->title;
        $this->description = $route->description;
        $this->is_active = $route->is_active;
        $this->sort_order = $route->sort_order;

        // Load days
        foreach ($route->days as $day) {
            $this->days[] = [
                'id' => $day->id, // Track ID for updates
                'day_number' => $day->day_number,
                'location_id' => $day->location_id,
                'title' => $day->title,
                'description' => $day->description,
                'place_ids' => $day->places->pluck('id')->toArray(),
                'hotel_ids' => $day->hotels->pluck('id')->toArray(),
            ];
        }

        if (empty($this->days)) {
            $this->addDay();
        }
    }

    public function addDay($sameDay = false)
    {
        $dayNumber = 1;
        if (!empty($this->days)) {
            $lastDay = end($this->days);
            $dayNumber = $sameDay ? $lastDay['day_number'] : $lastDay['day_number'] + 1;
        }

        $this->days[] = [
            'id' => null,
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
        // If it has an ID, we might need to delete it from DB on save.
        // We handle full sync on save, so just removing from array is fine.
        unset($this->days[$index]);
        $this->days = array_values($this->days);
        $this->normalizeDayNumbers();
    }

    public function normalizeDayNumbers()
    {
        if (empty($this->days)) {
            return;
        }

        $lastDayNum = null;
        $currentDay = 1;

        foreach ($this->days as $i => $day) {
            $thisDayNum = (int) $day['day_number'];

            if ($i === 0) {
                $currentDay = 1;
            } else {
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

        $route = Route::find($this->route_id);
        $route->update([
            'title' => $this->title,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ]);

        // Get IDs of days currently in the form
        $currentDayIds = array_filter(array_column($this->days, 'id'));

        // Delete days that are not in the form anymore
        $route->days()->whereNotIn('id', $currentDayIds)->delete();

        foreach ($this->days as $dayData) {
            $day = $route->days()->updateOrCreate(
                ['id' => $dayData['id'] ?? null],
                [
                    'day_number' => $dayData['day_number'],
                    'location_id' => $dayData['location_id'],
                    'title' => $dayData['title'],
                    'description' => $dayData['description'],
                ]
            );

            if (isset($dayData['place_ids'])) {
                $day->places()->sync($dayData['place_ids']);
            }
            if (isset($dayData['hotel_ids'])) {
                $day->hotels()->sync($dayData['hotel_ids']);
            }
        }

        session()->flash('saved', [
            'title' => 'Маршрут обновлен!',
            'text' => 'Маршрут успешно обновлен.',
        ]);
        return redirect()->route('admin.routes.index');
    }

    public function render()
    {
        $locations = Location::with(['places', 'hotels'])->orderBy('name')->get();
        return view('livewire.admin.routes.route-edit-component', compact('locations'))
            ->layout('layouts.app');
    }
}

<?php

namespace App\Livewire\Front;

use App\Models\TourGroup;
use Livewire\Component;
use Livewire\WithPagination;

class TourGroupsIndexComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public string $layout = 'layouts.front-app';
    public array $layoutData = ['hideCarousel' => true];
    public string $title = 'titles.tours';

    public ?int $month = null;
    public ?int $year = null;
    public int $perPage = 9;

    protected $queryString = [
        'month' => ['except' => null],
        'year' => ['except' => null],
    ];

    public function mount()
    {
        if (is_null($this->month)) {
            $this->month = now()->month;
        }
        if (is_null($this->year)) {
            $this->year = now()->year;
        }
    }

    public function updatingMonth($value)
    {
        $this->resetPage();
    }

    public function updatingYear($value)
    {
        $this->resetPage();
    }

    public function render()
    {
        $groups = TourGroup::with('tour')
            ->when($this->month, fn ($query) => $query->whereMonth('starts_at', $this->month))
            ->when($this->year, fn ($query) => $query->whereYear('starts_at', $this->year))
            ->orderBy('starts_at')
            ->paginate($this->perPage);

        return view('livewire.front.tour-groups-index', [
            'groups' => $groups,
            'months' => $this->getMonths(),
            'years' => $this->getYears(),
        ])->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.tour_show', ['tour' => __('Tour Groups')]));
    }

    private function getMonths(): array
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = __('months.' . $i);
        }
        return [null => __('Все месяцы')] + $months;
    }

    private function getYears(): array
    {
        $currentYear = now()->year;
        $years = [];
        for ($i = $currentYear - 2; $i <= $currentYear + 5; $i++) {
            $years[$i] = $i;
        }
        return [null => __('Все годы')] + $years;
    }
}

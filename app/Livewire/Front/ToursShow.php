<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\{Category, Tour, TourCategory, TourGroup, TourGroupService};

class ToursShow extends Component
{
    public Tour $tour;
    public ?int $selectedGroupId = null;
    public int $peopleCount = 1;
    public array $services = [];   // id => bool

    protected $rules = [
        'selectedGroupId' => 'required|exists:tour_groups,id',
        'peopleCount'     => 'required|integer|min:1|max:9',
    ];

    public function mount(Tour $tour)
    {
        $this->tour = $tour->load('groupsOpen', 'category');
    }

    public function getAvailableServicesProperty()
    {
        if(!$this->selectedGroupId) return collect();
        return TourGroupService::with('service')
            ->where('tour_group_id', $this->selectedGroupId)
            ->get();
    }

    public function addToCart()
    {
        $this->validate();

        $group = TourGroup::findOrFail($this->selectedGroupId);

        if($group->freePlaces() < $this->peopleCount) {
            session()->flash('error', 'Недостаточно свободных мест');
            return;
        }

        // кладём выбор во временную сессионную корзину
        $cart = session()->get('cart', []);
        $cart[] = [
            'tour_group_id' => $this->selectedGroupId,
            'people'        => $this->peopleCount,
            'services'      => array_keys(array_filter($this->services)),
        ];
        session()->put('cart', $cart);

        $this->dispatch('cartUpdated');
        session()->flash('message', 'Добавлено в корзину');
    }

    public function render()
    {
        $categories = TourCategory::with('tours')->get();
        return view('livewire.front.tours-show', compact('categories'))
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}

<?php

namespace App\Livewire\Admin\Tours;

use Livewire\Component;

class TourPricingTab extends Component
{
    public \App\Models\Tour $tour;

    // Cost Components (Inputs)
    public $cost_transport_cents; // Stored in cents, edited as normal currency in UI (need conversion)
    public $cost_guide_cents;
    public $cost_meal_per_day_cents;
    public $company_margin_percent;

    // Generated Matrix
    // array of [min_people, max_people, accommodation_type, price_cents, single_supplement_cents]
    public $pricingMatrix = [];

    protected $rules = [
        'cost_transport_cents' => 'required|numeric|min:0',
        'cost_guide_cents' => 'required|numeric|min:0',
        'cost_meal_per_day_cents' => 'required|numeric|min:0',
        'company_margin_percent' => 'required|numeric|min:0',
    ];

    public function mount(\App\Models\Tour $tour)
    {
        $this->tour = $tour;
        $this->loadCosts();
        $this->loadExistingPrices();
    }

    public function loadCosts()
    {
        $this->cost_transport_cents = $this->tour->cost_transport_cents;
        $this->cost_guide_cents = $this->tour->cost_guide_cents;
        $this->cost_meal_per_day_cents = $this->tour->cost_meal_per_day_cents;
        $this->company_margin_percent = $this->tour->company_margin_percent;
    }

    public function loadExistingPrices()
    {
        // Load existing prices from DB to matrix
        $prices = $this->tour->prices()->orderBy('min_people')->get();
        if ($prices->count() > 0) {
            $this->pricingMatrix = $prices->map(function ($p) {
                return [
                    'id' => $p->id,
                    'accommodation_type' => $p->accommodation_type,
                    'min_people' => $p->min_people,
                    'max_people' => $p->max_people,
                    'price' => $p->price_cents / 100, // display in normal currency
                    'single_supplement' => $p->single_supplement_cents ? $p->single_supplement_cents / 100 : 0,
                ];
            })->toArray();
        }
    }

    public function generatePrices()
    {
        $this->saveCosts(); // Save base costs first

        $calculator = new \App\Services\TourPriceCalculator();
        $rawMatrix = $calculator->calculateMatrix($this->tour, 1, 10);

        $newMatrix = [];

        // Convert calculator output to our matrix format
        // We will group by 1, 2, 3... for now flat list
        foreach ($rawMatrix as $peopleCount => $types) {
            foreach (['standard', 'comfort'] as $type) {
                if (isset($types[$type])) {
                    $data = $types[$type];
                    $newMatrix[] = [
                        'id' => null, // new row
                        'accommodation_type' => $type,
                        'min_people' => $peopleCount,
                        'max_people' => $peopleCount,
                        'price' => $data['price_cents'] / 100,
                        'single_supplement' => $data['single_supplement_cents'] / 100,
                    ];
                }
            }
        }

        // Replace current matrix with generated one
        // User can then edit and save to DB
        $this->pricingMatrix = $newMatrix;
    }

    public function saveCosts()
    {
        $this->validate();

        $this->tour->update([
            'cost_transport_cents' => $this->cost_transport_cents,
            'cost_guide_cents' => $this->cost_guide_cents,
            'cost_meal_per_day_cents' => $this->cost_meal_per_day_cents,
            'company_margin_percent' => $this->company_margin_percent,
        ]);

        $this->dispatch('alert', ['type' => 'success', 'message' => 'Costs saved successfully!']);
    }

    public function saveMatrix()
    {
        // Delete old prices
        $this->tour->prices()->delete();

        foreach ($this->pricingMatrix as $row) {
            $this->tour->prices()->create([
                'accommodation_type' => $row['accommodation_type'],
                'min_people' => $row['min_people'],
                'max_people' => $row['max_people'],
                'price_cents' => (int) ($row['price'] * 100),
                'single_supplement_cents' => (int) ($row['single_supplement'] * 100),
            ]);
        }

        $this->loadExistingPrices(); // reload to get IDs
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Price matrix saved!']);
    }

    public function render()
    {
        return view('livewire.admin.tours.tour-pricing-tab');
    }
}

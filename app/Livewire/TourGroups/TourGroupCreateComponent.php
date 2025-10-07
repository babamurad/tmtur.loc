<?php

namespace App\Livewire\TourGroups;

use App\Models\TourGroup;
use Livewire\Component;

class TourGroupCreateComponent extends Component
{
    public $tour_id;
    public $starts_at;
    public $max_people;
    public $current_people = 0;
    public $price_cents;
    public $status = 'draft'; // Default status

    protected function rules()
    {
        return [
            'tour_id' => 'required|exists:tours,id',
            'starts_at' => 'required|date',
            'max_people' => 'required|integer|min:1',
            'current_people' => 'nullable|integer|min:0|lte:max_people',
            'price_cents' => 'required|integer|min:0',
            'status' => 'required|in:draft,open,closed,cancelled',
        ];
    }

    public function render()
    {
        $tours = \App\Models\Tour::all(); // Fetch all tours for the dropdown
        return view('livewire.tour-groups.tour-group-create-component', [
            'tours' => $tours,
        ]);
    }

    public function save()
    {
        $this->validate();

        TourGroup::create([
            'tour_id' => $this->tour_id,
            'starts_at' => $this->starts_at,
            'max_people' => $this->max_people,
            'current_people' => $this->current_people,
            'price_cents' => $this->price_cents,
            'status' => $this->status,
        ]);

        session()->flash('saved', [
            'title' => 'Группа туров создана!',
            'text' => 'Создана новая группа туров!',
        ]);
        return redirect()->route('tour-groups.index');
    }
}
<?php

namespace App\Livewire\TourGroups;

use App\Models\TourGroup;
use Livewire\Component;

class TourGroupEditComponent extends Component
{
    public $tourGroup;
    public $tour_id;
    public $starts_at;
    public $max_people;
    public $current_people;
    public $price_cents;
    public $status;

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

    public function mount(TourGroup $tourGroup)
    {
        $this->tourGroup = $tourGroup;
        $this->tour_id = $tourGroup->tour_id;
        $this->starts_at = $tourGroup->starts_at->format('Y-m-d\TH:i'); // Format for datetime-local input
        $this->max_people = $tourGroup->max_people;
        $this->current_people = $tourGroup->current_people;
        $this->price_cents = $tourGroup->price_cents;
        $this->status = $tourGroup->status; // This will be 'draft', 'open', 'closed', or 'cancelled'
    }

    public function render()
    {
        $tours = \App\Models\Tour::all();
        return view('livewire.tour-groups.tour-group-edit-component', [
            'tours' => $tours,
        ]);
    }

    public function save()
    {
        $this->validate();

        $this->tourGroup->update([
            'tour_id' => $this->tour_id,
            'starts_at' => $this->starts_at,
            'max_people' => $this->max_people,
            'current_people' => $this->current_people,
            'price_cents' => $this->price_cents,
            'status' => $this->status,
        ]);

        session()->flash('saved', [
            'title' => 'Группа туров сохранена!',
            'text' => 'Изменения сохранились!',
        ]);
        return redirect()->route('tour-groups.index');
    }
}
<?php

namespace App\Livewire\TourGroups;

use App\Models\Service;
use App\Models\TourGroup;
use App\Models\TourGroupService;
use Livewire\Component;

class TourGroupEditComponent extends Component
{
    /* ---------- TourGroup ---------- */
    public TourGroup $tourGroup;
    public $tour_id;
    public $starts_at;
    public $max_people;
    public $current_people;
    public $price_cents;
    public $status;

    /* ---------- Services ---------- */
    public $services = [];          // все услуги
    public array $checked = [];     // id => bool
    public array $prices = [];      // id => cents
    public array $details = [];     // id => json (если нужно)
    public string $search = '';     // строка поиска

    protected function rules(): array
    {
        return [
            'tour_id'        => 'required|exists:tours,id',
            'starts_at'      => 'required|date',
            'max_people'     => 'required|integer|min:1',
            'current_people' => 'nullable|integer|min:0|lte:max_people',
            'price_cents'    => 'required|integer|min:0',
            'status'         => 'required|in:draft,open,closed,cancelled',
            'prices.*'       => 'nullable|integer|min:0',
        ];
    }

    public function mount(TourGroup $tourGroup)
    {
        $this->tourGroup = $tourGroup;

        // 1. обычные поля
        $this->tour_id        = $this->tourGroup->tour_id;
        $this->starts_at      = $this->tourGroup->starts_at;
        $this->max_people     = $this->tourGroup->max_people;
        $this->current_people = $this->tourGroup->current_people;
        $this->price_cents    = $this->tourGroup->price_cents;
        $this->status         = $this->tourGroup->status;

        // 2. услуги
        $this->services = Service::orderBy('name')->get();

        foreach ($this->services as $s) {
            $id = (int)$s->id;
//            $pivot = $tourGroup->tourGroupServices()
//                ->where('service_id', $id)
//                ->first();

//            $this->checked[$id] = (bool)$pivot;
//            $this->prices[$id]  = $pivot?->price_cents ?? $s->default_price_cents;
//            $this->details[$id] = $pivot?->details;
        }
    }

    public function save()
    {
        $this->validate();

        // 1. обновляем TourGroup
        $this->tourGroup->update([
            'tour_id'        => $this->tour_id,
            'starts_at'      => $this->starts_at,
            'max_people'     => $this->max_people,
            'current_people' => $this->current_people,
            'price_cents'    => $this->price_cents,
            'status'         => $this->status,
        ]);

        // 2. sync услуг (HasMany)
        $wanted = collect($this->services)
            ->filter(fn($s) => $this->checked[(int)$s->id])
            ->pluck('id');

        // 2а. удаляем лишние
        $this->tourGroup->tourGroupServices()
            ->whereNotIn('service_id', $wanted)
            ->delete();

        // 2б. создаём / обновляем
        foreach ($wanted as $id) {
            $this->tourGroup->tourGroupServices()->updateOrCreate(
                ['service_id' => $id],
                [
                    'price_cents' => $this->prices[$id],
                    'details'     => $this->details[$id] ?? null,
                ]
            );
        }

        session()->flash('saved', [
            'title' => 'Группа туров сохранена!',
            'text'  => 'Услуги обновлены.',
        ]);
        return redirect()->route('tour-groups.index');
    }

    public function render()
    {
        return view('livewire.tour-groups.tour-group-edit-component', [
            'tours' => \App\Models\Tour::all(),
        ]);
    }
}

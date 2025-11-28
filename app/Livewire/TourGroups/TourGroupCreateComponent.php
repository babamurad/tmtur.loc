<?php

namespace App\Livewire\TourGroups;

use App\Models\Booking;
use App\Models\Service;
use App\Models\TourGroup;
use App\Models\TourGroupService;
use Livewire\Component;

class TourGroupCreateComponent extends Component
{
    /* --------- основные поля TourGroup --------- */
    public $tour_id;
    public $starts_at;
    public $max_people;
    public $current_people = 0;
    public $price_cents;
    public $status = 'draft';

    /* --------- массив услуг, пришедших из БД --------- */
    public $services = [];

    /* --------- цены, которые вводит админ --------- */
    public array $servicePrices = [];   // [serviceId => price_cents]

    /* --------- чекбоксы «использовать услугу» --------- */
    public array $serviceChecked = []; // [serviceId => bool]

    protected function rules(): array
    {
        return [
            'tour_id'        => 'required|exists:tours,id',
            'starts_at'      => 'required|date',
            'max_people'     => 'required|integer|min:1',
            'current_people' => 'nullable|integer|min:0|lte:max_people',
            'price_cents'    => 'required|integer|min:0',
            'status'         => 'required|in:draft,open,closed,cancelled',

            /* валидация цен только для отмеченных услуг */
            'servicePrices.*'=> 'nullable|integer|min:0',
        ];
    }

    protected function messages(): array
    {
        return [
            'tour_id.required'        => 'Необходимо выбрать тур.',
            'tour_id.exists'          => 'Выбранный тур не существует.',
            'starts_at.required'      => 'Укажите дату начала.',
            'starts_at.date'          => 'Некорректный формат даты.',
            'max_people.required'     => 'Укажите максимальное количество людей.',
            'max_people.integer'      => 'Количество людей должно быть целым числом.',
            'max_people.min'          => 'Минимальное количество людей — 1.',
            'current_people.integer'  => 'Текущее количество людей должно быть целым числом.',
            'current_people.min'      => 'Количество людей не может быть отрицательным.',
            'current_people.lte'      => 'Текущее количество людей не может превышать максимальное.',
            'price_cents.required'    => 'Укажите цену.',
            'price_cents.integer'     => 'Цена должна быть целым числом.',
            'price_cents.min'         => 'Цена не может быть отрицательной.',
            'status.required'         => 'Выберите статус.',
            'status.in'               => 'Некорректный статус.',
            'servicePrices.*.integer' => 'Цена услуги должна быть целым числом.',
            'servicePrices.*.min'     => 'Цена услуги не может быть отрицательной.',
        ];
    }

    public function mount()
    {
        // Загружаем список всех услуг один раз
        $this->services = Service::all();

        // Инициализируем массивы
        foreach ($this->services as $s) {
            $this->serviceChecked[$s->id]  = false;
            $this->servicePrices[$s->id]   = $s->default_price_cents;
        }
    }

    public function save()
    {
        $this->validate();

        $tourGroup = TourGroup::create([
            'tour_id'         => $this->tour_id,
            'starts_at'       => $this->starts_at,
            'max_people'      => $this->max_people,
            'current_people'  => $this->current_people,
            'price_cents'     => $this->price_cents,
            'status'          => $this->status,
        ]);

        // Сохраняем связанные услуги
        foreach ($this->services as $s) {
            if ($this->serviceChecked[$s->id]) {
                TourGroupService::create([
                    'tour_group_id' => $tourGroup->id,
                    'service_id'    => $s->id,
                    'price_cents'   => $this->servicePrices[$s->id],
                ]);
            }
        }

        session()->flash('saved', [
            'title' => 'Группа туров создана!',
            'text'  => 'Создана новая группа туров c услугами.',
        ]);

        return redirect()->route('tour-groups.index');
    }

    public function render()
    {
        return view('livewire.tour-groups.tour-group-create-component', [
            'tours' => \App\Models\Tour::all(), // для выпадающего списка
        ]);
    }
}

<?php

namespace App\Livewire\Tours;

use App\Models\Tour;
use Livewire\Component;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithPagination;

class TourIndexComponent extends Component
{
    use WithPagination;

    public $delId;
    public $perPage = 12;
    public $search = '';

    public function render()
    {
        // Обновляем запрос, чтобы использовать short_description вместо description
        $tours = Tour::with('category', 'media') // Обновляем связь на 'category'
        ->when($this->search, function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                // Ищем в short_description, если поле теперь хранит краткое описание
                ->orWhere('short_description', 'like', '%' . $this->search . '%');
            // Если вы храните изображения в другой таблице (например, media), добавьте JOIN или используйте отношения для поиска по названию файла
        })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.tours.tour-index-component', [
            'tours' => $tours,
        ]);
    }

    public function mount()
    {
        if (session()->has('saved')) {
            LivewireAlert::title(session('saved.title'))
                ->text(session('saved.text'))
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        $this->resetPage();
        $this->perPage = $value;
    }

    public function delete($id)
    {
        info("Delete: " . $id);
        $this->delId = $id;
        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить тур?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('tourDelete')
            ->show(null, ['backdrop' => true]);
    }

    public function tourDelete()
    {
        $tour = Tour::findOrFail($this->delId);
        info("Deleting tour: " . $tour->title); // Лучше логировать название, чем объект
        $tour->delete(); // Это каскадно удалит связанные записи в tour_itinerary_days, tour_inclusions, tour_accommodations и tour_groups (если настроено)

        LivewireAlert::title('Тур удален.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }
}

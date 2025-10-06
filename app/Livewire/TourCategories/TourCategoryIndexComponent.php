<?php

namespace App\Livewire\TourCategories;

use App\Models\TourCategory;
use Livewire\Component;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithPagination;

class TourCategoryIndexComponent extends Component
{
    use WithPagination;

    public $delId;

    public function render()
    {
        $tourCategories = TourCategory::orderBy('id', 'desc')->paginate(8);
        return view('livewire.tour-categories.tour-category-index-component', [
            'tourCategories' => $tourCategories,
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

    public function delete($id)
    {
        info("Delete: " . $id);
        $this->delId = $id;
        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить категорию тура?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('tourCategoryDelete')
            ->show();
    }

    public function tourCategoryDelete()
    {
        $tourCategory = TourCategory::findOrFail($this->delId);
        info("Deleting tour category: " . $tourCategory);
        $tourCategory->delete();

        LivewireAlert::title('Категория тура удалена.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }
}
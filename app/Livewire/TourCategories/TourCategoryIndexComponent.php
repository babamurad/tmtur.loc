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
    public $status = 'active';

    public function render()
    {
        $query = TourCategory::orderBy('id', 'desc');

        if ($this->status === 'trashed') {
            $query->onlyTrashed();
        }

        $tourCategories = $query->paginate(8);

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

    // --- Soft Delete (Move to Trash) ---
    public function delete($id)
    {
        $this->delId = $id;
        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите переместить категорию в корзину?')
            ->timer(5000)
            ->withConfirmButton('Да, в корзину')
            ->withCancelButton('Отмена')
            ->onConfirm('tourCategoryDelete')
            ->show();
    }

    public function tourCategoryDelete()
    {
        $tourCategory = TourCategory::findOrFail($this->delId);
        $tourCategory->delete();

        LivewireAlert::title('Категория перемещена в корзину.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    // --- Restore ---
    public function restore($id)
    {
        $tourCategory = TourCategory::onlyTrashed()->findOrFail($id);
        $tourCategory->restore();

        LivewireAlert::title('Категория восстановлена.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    // --- Force Delete ---
    public function forceDeleteRequest($id)
    {
        $this->delId = $id;
        LivewireAlert::title('Удалить навсегда?')
            ->text('Это действие необратимо!')
            ->timer(5000)
            ->withConfirmButton('Да, удалить')
            ->withCancelButton('Отмена')
            ->onConfirm('tourCategoryForceDelete')
            ->show();
    }

    public function tourCategoryForceDelete()
    {
        $tourCategory = TourCategory::onlyTrashed()->findOrFail($this->delId);
        $tourCategory->forceDelete();

        LivewireAlert::title('Категория удалена навсегда.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }
}
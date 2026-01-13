<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class PagesIndexComponent extends Component
{
    use WithPagination;

    public $pageId;

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

    protected $listeners = ['confirmDelete'];

    public function delete($id)
    {
        $this->pageId = $id;

        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить эту страницу?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('confirmDelete')
            ->show(null, ['backdrop' => true]);
    }

    public function confirmDelete()
    {
        $page = Page::find($this->pageId);

        if ($page) {
            $page->delete();

            LivewireAlert::title('Страница удалена')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }

    public function render()
    {
        $pages = Page::paginate(10);
        return view('livewire.admin.pages.pages-index-component', ['pages' => $pages])->layout('layouts.app');
    }
}

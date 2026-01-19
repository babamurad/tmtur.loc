<?php

namespace App\Livewire\Gallery;

use App\Models\TurkmenistanGallery;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class GalleryIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $delId;
    public $perPage = 12; // Количество изображений на странице
    public $search = '';
    public $filterFeatured = false;
    public $filterLocation = '';

    protected $queryString = ['search', 'filterFeatured', 'filterLocation'];

    public function mount()
    {
        if (session()->has('saved')) {
            LivewireAlert::title(session('saved.title'))
                ->text(session('saved.text') ?? '')
                ->success()
                ->position('top-end')
                ->timer(3000)
                ->toast()
                ->show();
        }
    }

    public function render()
    {
        $query = TurkmenistanGallery::query();

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('location', 'like', '%' . $this->search . '%')
                ->orWhere('photographer', 'like', '%' . $this->search . '%');
        }

        if ($this->filterFeatured) {
            $query->where('is_featured', true);
        }

        if ($this->filterLocation) {
            $query->where('location', $this->filterLocation);
        }

        $galleries = $query->orderBy('order')
            ->orderBy('created_at', 'desc') // Резервная сортировка
            ->paginate($this->perPage);

        // Получим уникальные локации для фильтра
        $locations = TurkmenistanGallery::select('location')
            ->distinct()
            ->whereNotNull('location')
            ->orderBy('location')
            ->pluck('location');

        return view('livewire.gallery.gallery-index', [
            'galleries' => $galleries,
            'locations' => $locations,
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterFeatured()
    {
        $this->resetPage();
    }

    public function updatedFilterLocation()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $this->delId = $id;

        $this->delId = $id;
        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить тур?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('photoDelete')
            ->show(null, ['backdrop' => true]);
    }

    public function photoDelete()
    {
        $photo = TurkmenistanGallery::findOrFail($this->delId);

        // Удаляем файл изображения
        if ($photo->file_path && file_exists(public_path('uploads/' . $photo->file_path))) {
            unlink(public_path('uploads/' . $photo->file_path));
        }

        // Удаляем запись из БД (вместе с переводами благодаря модели)
        $photo->delete();

        LivewireAlert::title('Фотография удалена!')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }
}

<?php

namespace App\Livewire\Gallery;

use App\Models\TurkmenistanGallery;
use Livewire\Component;
use Livewire\WithPagination;

class GalleryIndex extends Component
{
    use WithPagination;

    public $perPage = 12; // Количество изображений на странице
    public $search = '';
    public $filterFeatured = false;
    public $filterLocation = '';

    protected $queryString = ['search', 'filterFeatured', 'filterLocation'];

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
}

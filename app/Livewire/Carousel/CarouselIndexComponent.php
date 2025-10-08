<?php

namespace App\Livewire\Carousel;

use App\Models\CarouselSlide;
use Livewire\Component;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class CarouselIndexComponent extends Component
{
    use WithPagination;

    public $delId;
    public $perPage = 8;
    public $search = '';

    public function render()
    {
        $carouselSlides = CarouselSlide::when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.carousel.carousel-index-component', [
            'carouselSlides' => $carouselSlides,
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
        $this->delId = $id;
        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить слайд карусели?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('carouselSlideDelete')
            ->show();
    }

    public function carouselSlideDelete()
    {
        $carouselSlide = CarouselSlide::findOrFail($this->delId);
        // Удаляем изображение, если оно есть
        // $filePath = $product->thumb_image;
        //     $directory = 'products'; // Укажите вашу директорию хранения изображений
        //     $this->deleteImage($filePath, $directory);

        if ($carouselSlide->image && Storage::disk('public_uploads')->exists('carousel/' . $carouselSlide->image)) {
            Storage::disk('public')->delete('carousel/' . $carouselSlide->image);
        }
        $carouselSlide->delete();

        LivewireAlert::title('Слайд карусели удален.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }
}

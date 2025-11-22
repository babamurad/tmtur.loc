<?php

namespace App\Livewire\Carousel;

use App\Models\CarouselSlide;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CarouselCreateComponent extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $image;
    public $button_text;
    public $button_link;
    public $sort_order = 0;
    public $is_active = true;
    public array $trans = [];

    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|max:2048', // 2MB Max
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255|url',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.description"] = 'nullable|string|max:1000';
            $rules["trans.$l.button_text"] = 'nullable|string|max:255';
        }

        return $rules;
    }

    public function mount()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = '';
            $this->trans[$locale]['description'] = '';
            $this->trans[$locale]['button_text'] = '';
        }
    }

    public function render()
    {
        return view('livewire.carousel.carousel-create-component');
    }

    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imageName = 'carousel/' . Carbon::now()->timestamp . '.' . $this->image->extension();
            $imagePath = $this->image->storeAs($imageName); // Store in public/uploads/carousel
        }

        $carouselSlide = CarouselSlide::create([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imageName, // Save only the file name
            'button_text' => $this->button_text,
            'button_link' => $this->button_link,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);

        // Save translations
        $fallbackLocale = config('app.fallback_locale');
        $this->trans[$fallbackLocale]['title'] = $this->title;
        $this->trans[$fallbackLocale]['description'] = $this->description;
        $this->trans[$fallbackLocale]['button_text'] = $this->button_text;

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $carouselSlide->setTr($field, $locale, $value);
            }
        }

        session()->flash('saved', [
            'title' => 'Слайд карусели создан!',
            'text' => 'Новый слайд успешно добавлен.',
        ]);

        return redirect()->route('carousels.index');
    }
}

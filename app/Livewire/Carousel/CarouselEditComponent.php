<?php

namespace App\Livewire\Carousel;

use App\Models\CarouselSlide;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CarouselEditComponent extends Component
{
    use WithFileUploads;

    public $carouselSlide;
    public $title;
    public $description;
    public $newImage; // Для нового изображения
    public $currentImage; // Для отображения текущего изображения
    public $button_text;
    public $button_link;
    public $sort_order;
    public $is_active;
    public array $trans = [];

    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'newImage' => 'nullable|image|max:2048', // 2MB Max
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

    public function mount($id)
    {
        $carouselSlide = CarouselSlide::find($id);

        if (!$carouselSlide) {
            abort(404);
        }
        $this->carouselSlide = $carouselSlide;
        $this->title = $carouselSlide->title;
        $this->description = $carouselSlide->description;
        $this->currentImage = $carouselSlide->image; // Путь к текущему изображению
        $this->button_text = $carouselSlide->button_text;
        $this->button_link = $carouselSlide->button_link;
        $this->sort_order = $carouselSlide->sort_order;
        $this->is_active = $carouselSlide->is_active;

        // Load translations
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = $carouselSlide->tr('title', $locale);
            $this->trans[$locale]['description'] = $carouselSlide->tr('description', $locale);
            $this->trans[$locale]['button_text'] = $carouselSlide->tr('button_text', $locale);
        }
    }

    public function render()
    {
        return view('livewire.carousel.carousel-edit-component');
    }

    public function save()
    {
        $this->validate();

        $imageName = $this->currentImage; // По умолчанию оставляем текущее изображение

        if ($this->newImage) {
            // Удаляем старое изображение, если оно существует
            if ($this->currentImage && Storage::disk('public')->exists('carousel/' . $this->currentImage)) {
                Storage::disk('public')->delete('carousel/' . $this->currentImage);
            }
            // Сохраняем новое изображение
            $imageName = 'carousel/' . Carbon::now()->timestamp . '.' . $this->newImage->extension();
            $this->newImage->storeAs('public', $imageName);
        }

        $this->carouselSlide->update([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imageName,
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
                $this->carouselSlide->setTr($field, $locale, $value);
            }
        }

        $this->carouselSlide->flushTrCache();

        session()->flash('saved', [
            'title' => 'Слайд карусели обновлен!',
            'text' => 'Изменения успешно сохранены.',
        ]);

        return redirect()->route('carousels.index');
    }
}

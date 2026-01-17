<?php

namespace App\Livewire\Gallery;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\TurkmenistanGallery;
use App\Services\ImageService;
use Illuminate\Validation\Rule;

class GalleryCreate extends Component
{
    use WithFileUploads;
    use \App\Livewire\Traits\HasGeminiTranslation;

    /* основные поля */
    public string $title = '';
    public int $order = 0;
    public bool $is_featured = false;

    /* загружаемый файл */
    public $photo;

    /* мультиязычные значения */
    public array $trans = [];

    /* правила */
    protected function rules(): array
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'order' => 'integer|min:0',
            'is_featured' => 'boolean',
            'photo' => 'required|image|max:2048', // 2 МБ
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.description"] = 'nullable|string';
            $rules["trans.$l.location"] = 'nullable|string|max:255';
            $rules["trans.$l.photographer"] = 'nullable|string|max:255';
            $rules["trans.$l.alt_text"] = 'nullable|string|max:255';
        }

        return $rules;
    }

    public function mount()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = '';
            $this->trans[$locale]['description'] = '';
            $this->trans[$locale]['location'] = '';
            $this->trans[$locale]['photographer'] = '';
            $this->trans[$locale]['alt_text'] = '';
        }
    }

    /* сохранение */
    public function save()
    {
        $fallback = config('app.fallback_locale');
        $this->trans[$fallback]['title'] = $this->title;

        $this->validate();

        /* загрузка файла */
        $imageService = new ImageService();
        $optimized = $imageService->saveOptimized($this->photo, 'gallery');

        /* запись в БД */
        $gallery = TurkmenistanGallery::create([
            'title' => $this->trans[$fallback]['title'],
            // 'slug'         => Str::slug($this->title),
            'description' => $this->trans[$fallback]['description'] ?? '',
            'file_path' => $optimized['path'],
            'file_name' => $optimized['file_name'],
            'mime_type' => $optimized['mime_type'],
            'size' => $optimized['size'],
            'alt_text' => $this->trans[$fallback]['alt_text'] ?? '',
            'location' => $this->trans[$fallback]['location'] ?? '',
            'photographer' => $this->trans[$fallback]['photographer'] ?? '',
            'order' => $this->order,
            'is_featured' => $this->is_featured,
        ]);

        // Сохраняем переводы
        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $gallery->setTr($field, $locale, $value);
            }
        }

        session()->flash('saved', ['title' => 'Фото добавлено!', 'text' => '']);
        return redirect()->route('gallery.index');
    }

    /* рендер */
    public function render()
    {
        return view('livewire.gallery.gallery-create');
    }

    protected function getTranslatableFields(): array
    {
        return ['title', 'description', 'location', 'photographer', 'alt_text'];
    }

    protected function getTranslationContext(): string
    {
        return 'туристическая фотогалерея, описание достопримечательностей Туркменистана';
    }
}

<?php

namespace App\Livewire\Gallery;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\TurkmenistanGallery;
use App\Services\ImageService;

class GalleryEdit extends Component
{
    use WithFileUploads;
    use \App\Livewire\Traits\HasGeminiTranslation;

    public TurkmenistanGallery $photo; // текущая запись

    /* редактируемые поля */
    public string $title = '';
    public int $order = 0;
    public bool $is_featured = false;

    /* новый файл (если пользователь загрузит) */
    public $newPhoto = null;

    /* мультиязычные значения */
    public array $trans = [];

    /* правила */
    protected function rules(): array
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'order' => 'integer|min:0',
            'is_featured' => 'boolean',
            'newPhoto' => 'nullable|image|max:2048',
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

    /* загружаем данные */
    public function mount(int $id): void
    {
        $this->photo = TurkmenistanGallery::findOrFail($id);

        $this->title = $this->photo->title;
        $this->order = $this->photo->order;
        $this->is_featured = $this->photo->is_featured;

        // Загружаем переводы
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = $this->photo->tr('title', $locale);
            $this->trans[$locale]['description'] = $this->photo->tr('description', $locale);
            $this->trans[$locale]['location'] = $this->photo->tr('location', $locale);
            $this->trans[$locale]['photographer'] = $this->photo->tr('photographer', $locale);
            $this->trans[$locale]['alt_text'] = $this->photo->tr('alt_text', $locale);
        }
    }

    /* сохранение */
    public function save()
    {
        $fallback = config('app.fallback_locale');
        $this->trans[$fallback]['title'] = $this->title;

        $this->validate();

        /* если загружен новый файл – заменяем */
        if ($this->newPhoto) {
            $imageService = new ImageService();
            /* удаляем старый */
            if ($this->photo->file_path) {
                // Assuming simple delete, or use ImageService::delete if applicable for Gallery logic
                Storage::disk('public_uploads')->delete($this->photo->file_path);
            }

            $optimized = $imageService->saveOptimized($this->newPhoto, 'gallery');

            $this->photo->update([
                'file_path' => $optimized['path'],
                'file_name' => $optimized['file_name'],
                'mime_type' => $optimized['mime_type'],
                'size' => $optimized['size'],
            ]);
        }

        /* обновляем остальные поля */
        $this->photo->update([
            'title' => $this->trans[$fallback]['title'],
            'description' => $this->trans[$fallback]['description'] ?? '',
            'location' => $this->trans[$fallback]['location'] ?? '',
            'photographer' => $this->trans[$fallback]['photographer'] ?? '',
            'alt_text' => $this->trans[$fallback]['alt_text'] ?? '',
            'order' => $this->order,
            'is_featured' => $this->is_featured,
        ]);

        // Сохраняем переводы
        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $this->photo->setTr($field, $locale, $value);
            }
        }

        session()->flash('saved', ['title' => 'Фото обновлено!', 'text' => '']);
        return redirect()->route('gallery.index');
    }

    /* рендер */
    public function render()
    {
        return view('livewire.gallery.gallery-edit');
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

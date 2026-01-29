<?php

namespace App\Livewire\TourCategories;

use App\Models\TourCategory;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class TourCategoryEditComponent extends Component
{
    use WithFileUploads;
    use \App\Livewire\Traits\HasGeminiTranslation;
    public $tourCategory;
    // public $title; // Removed in favor of trans
    // public $content; // Removed in favor of trans
    public $slug;
    public $image;
    public $is_published;
    public array $trans = [];

    protected $listeners = ['quillUpdated' => 'updateQuillField'];

    public function updateQuillField($data)
    {
        data_set($this, $data['field'], $data['value']);
    }

    protected function rules()
    {
        $rules = [
            'slug' => 'nullable|min:3|max:255|unique:tour_categories,slug,' . $this->tourCategory->id,
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.content"] = 'nullable|string';
        }

        return $rules;
    }

    public function mount($id)
    {
        $this->tourCategory = TourCategory::findOrFail($id);

        $this->slug = $this->tourCategory->slug;
        $this->image = $this->tourCategory->image; // Keep as string path? Model accessor?
        // In TourEditComponent: $this->image = $tour->media ? ... : null;
        // Here existing code was: $this->image = $this->tourCategory->image;
        // Assuming it's a string path in DB for now based on existing code.

        $this->is_published = $this->tourCategory->is_published;

        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = $this->tourCategory->tr('title', $locale);
            $this->trans[$locale]['content'] = $this->tourCategory->tr('content', $locale);
        }
    }

    public function render()
    {
        return view('livewire.tour-categories.tour-category-edit-component');
    }

    public function generateSlug()
    {
        $fallbackLocale = config('app.fallback_locale');
        $title = $this->trans[$fallbackLocale]['title'] ?? '';
        $this->slug = Str::slug($title);
    }

    public function save()
    {
        $this->validate();

        $fallbackLocale = config('app.fallback_locale');

        $this->tourCategory->update([
            'title' => $this->trans[$fallbackLocale]['title'] ?? '',
            'content' => $this->trans[$fallbackLocale]['content'] ?? '',
            // 'slug' => $this->slug, // Commented out in original too
            'image' => $this->image,
            'is_published' => $this->is_published,
        ]);

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $this->tourCategory->setTr($field, $locale, $value);
            }
        }

        $this->tourCategory->flushTrCache();

        session()->flash('saved', [
            'title' => 'Категория тура сохранена!',
            'text' => 'Изменения сохранились!',
        ]);
        return redirect()->route('tour-categories.index');
    }

    protected function getTranslatableFields(): array
    {
        return ['title', 'content'];
    }

    protected function getTranslationContext(): string
    {
        return 'Категория туров';
    }
}

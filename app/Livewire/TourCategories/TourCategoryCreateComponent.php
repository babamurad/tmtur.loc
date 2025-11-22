<?php

namespace App\Livewire\TourCategories;

use App\Models\TourCategory;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class TourCategoryCreateComponent extends Component
{
    use WithFileUploads;

    public array $trans = [];
    public $slug;
    public $image;
    public $is_published = true;

    protected $listeners = ['quillUpdated' => 'updateQuillField'];

    public function updateQuillField($data)
    {
        data_set($this, $data['field'], $data['value']);
    }

    protected function rules()
    {
        $rules = [
            'slug' => 'nullable|min:3|max:255|unique:tour_categories,slug',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.content"] = 'nullable|string';
        }

        return $rules;
    }

    public function render()
    {
        return view('livewire.tour-categories.tour-category-create-component');
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
        $title = $this->trans[$fallbackLocale]['title'] ?? '';

        if (empty($this->slug)) {
            $this->slug = Str::slug($title);
        }

        $tourCategory = TourCategory::create([
            'title' => $title,
            'slug' => $this->slug,
            'content' => $this->trans[$fallbackLocale]['content'] ?? '',
            'image' => $this->image,
            'is_published' => $this->is_published,
        ]);

        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $tourCategory->setTr($field, $locale, $value);
            }
        }

        $tourCategory->flushTrCache();

        session()->flash('saved', [
            'title' => 'Категория тура создана!',
            'text' => 'Создана новая категория тура!',
        ]);
        return redirect()->route('tour-categories.index');
    }
}
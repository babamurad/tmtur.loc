<?php

namespace App\Livewire\Guides;

use App\Models\Guide;
use Livewire\Component;
use Livewire\WithFileUploads;

class GuideEditComponent extends Component
{
    use WithFileUploads;

    public Guide $guide;                  // route-model-binding
    public $name, $description, $specialization, $experience_years;
    public $is_active, $sort_order, $languages = [];
    public $image;                        // новая картинка
    public $oldImage;                     // путь старой картинки (если нужно)

    protected function rules(): array
    {
        return [
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'specialization'    => 'nullable|string|max:255',
            'experience_years'  => 'nullable|integer|min:0',
            'is_active'         => 'boolean',
            'sort_order'        => 'integer',
            'languages'         => 'required|array|min:1',
            'languages.*'       => 'string|in:ru,en,tm',
            'image'             => 'nullable|image|max:2048',
        ];
    }

    public function mount(Guide $guide)
    {
        $this->guide   = $guide;
        $this->fill($guide->only([
            'name','description','specialization',
            'experience_years','is_active','sort_order','languages'
        ]));
        $this->oldImage = $guide->image;
    }

    public function update()
    {
        $this->validate();

        $data = $this->except(['guide', 'image', 'oldImage']);

        if ($this->image) {
            $data['image'] = $this->image->store('guides', 'public');
        }

        $this->guide->update($data);

        session()->flash('success', 'Гид обновлён.');
        return redirect()->route('guides.index');
    }

    public function render()
    {
        return view('livewire.guides.guide-edit-component', [
            'availableLangs' => ['ru' => 'Русский', 'en' => 'English', 'tm' => 'Türkmen'],
            'guide'          => $this->guide,   // на всякий случай
        ]);
    }
}

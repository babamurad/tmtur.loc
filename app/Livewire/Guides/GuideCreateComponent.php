<?php

namespace App\Livewire\Guides;

use App\Models\Guide;
use Livewire\Component;
use Livewire\WithFileUploads;

class GuideCreateComponent extends Component
{
    use WithFileUploads;

    public $name, $description, $specialization, $experience_years = 0;
    public $is_active = true, $sort_order = 0, $languages = [];
    public $image;                       // временное поле загрузки

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
            'languages.*'       => 'string|in:ru,en,tm',   // разрешённые коды
            'image'             => 'nullable|image|max:2048',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = $this->only([
            'name','description','specialization',
            'experience_years','is_active','sort_order','languages'
        ]);

        if ($this->image) {
            $data['image'] = $this->image->storeAs('guides');
        }

        Guide::create($data);

        session()->flash('success', 'Гид создан.');
        return redirect()->route('guides.index');
    }

    public function render()
    {
        return view('livewire.guides.guide-create-component', [
            'availableLangs' => ['ru' => 'Русский', 'en' => 'English', 'tm' => 'Türkmen'],
        ]);
    }
}

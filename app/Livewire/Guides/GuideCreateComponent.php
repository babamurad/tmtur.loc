<?php
namespace App\Livewire\Guides;

use App\Models\Guide;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GuideCreateComponent extends Component
{
    use WithFileUploads;

    /* --- поля формы --- */
    public $name, $description, $specialization, $experience_years = 0;
    public $sort_order = 0, $is_active = true, $languages = [];
    public $image;                      // временное поле загрузки

    /* --- правила --- */
    protected function rules(): array
    {
        return [
            'name'             => 'required|string|max:255',
            'description'      => 'required|string',
            'specialization'   => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'sort_order'       => 'integer|min:0',
            'is_active'        => 'boolean',
            'languages'        => 'required|array|min:1',
            'languages.*'      => 'in:ru,en,tm',
            'image'            => 'nullable|image|max:2048',
        ];
    }

    /* --- сохранение --- */
    public function save()
    {
        $this->validate();

        $data = $this->only([
            'name','description','specialization',
            'experience_years','sort_order','is_active','languages'
        ]);

        if ($this->image) {
            // сохраняем в uploads/guides/..., диск public_uploads
            $data['image'] = $this->image->storeAs(
                'guides',
                \Illuminate\Support\Str::uuid() . '.' . $this->image->extension(),
                'public_uploads'          // <-- ваш диск
            );
        }

        Guide::create($data);

        session()->flash('success','Гид создан.');
        return redirect()->route('guides.index');
    }

    /* --- рендер --- */
    public function render()
    {
        return view('livewire.guides.guide-create-component', [
            'availableLangs' => ['ru'=>'Русский','en'=>'English','tm'=>'Türkmen'],
        ]);
    }
}

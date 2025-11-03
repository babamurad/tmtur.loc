<?php
namespace App\Livewire\Guides;

use App\Models\Guide;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Support\AvailableLanguages;

class GuideEditComponent extends Component
{
    use WithFileUploads;

    /* ---------- модель ---------- */
    public Guide $guide;

    /* ---------- поля формы ---------- */
    public $name, $description, $specialization, $experience_years;
    public $sort_order, $is_active, $languages = [];
    public $newImage;              // новая картинка
    public $currentImage;          // старая картинка

    /* ---------- добавление языков ---------- */
    public $newCode = '', $newName = '';

    /* ---------- правила ---------- */
    protected function rules(): array
    {
        $codes = implode(',', array_keys(AvailableLanguages::all()));
        return [
            'name'             => 'required|string|max:255',
            'description'      => 'required|string',
            'specialization'   => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'sort_order'       => 'integer|min:0',
            'is_active'        => 'boolean',
            'newImage'         => 'nullable|image|max:2048',
            'languages'        => 'required|array|min:1',
            'languages.*'      => 'in:'.$codes,
        ];
    }

    /* ---------- загрузка ---------- */
    public function mount($id)
    {
        $this->guide = Guide::findOrFail($id);

        $this->fill($this->guide->only([
            'name','description','specialization','experience_years',
            'sort_order','is_active'
        ]));
        $this->languages  = $this->guide->languages ?? [];
        $this->currentImage = $this->guide->image;
    }

    /* ---------- обновление ---------- */
    public function save()
    {
        $this->validate();

        $data = $this->only([
            'name','description','specialization','experience_years',
            'sort_order','is_active','languages'
        ]);

        if ($this->newImage) {
            if ($this->currentImage) {
                Storage::disk('public_uploads')->delete($this->currentImage);
            }
            $data['image'] = $this->newImage->storeAs(
                'guides',
                Str::uuid() . '.' . $this->newImage->extension(),
                'public_uploads'
            );
        } else {
            $data['image'] = $this->currentImage;
        }

        $this->guide->update($data);

        session()->flash('success','Гид обновлён.');
        return redirect()->route('guides.index');
    }

    /* ---------- добавить язык ---------- */
    public function addLanguage()
    {
        $this->validate([
            'newCode' => 'required|alpha|size:2|not_in:'.implode(',', array_keys(AvailableLanguages::all())),
            'newName' => 'required|string|max:30',
        ], [
            'not_in' => 'Такой код уже существует'
        ]);

        AvailableLanguages::add(strtolower($this->newCode), $this->newName);
        $this->reset('newCode','newName');
    }

    /* ---------- удалить язык ---------- */
    public function deleteLanguage(string $code)
    {
        if (in_array($code, $this->languages)) {
            $this->addError('languages','Сначала снимите галочку у этого языка');
            return;
        }
        AvailableLanguages::remove($code);
    }

    /* ---------- рендер ---------- */
    public function render()
    {
        return view('livewire.guides.guide-edit-component');
    }
}

<?php
namespace App\Livewire\Guides;

use App\Models\Guide;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Support\AvailableLanguages;

class GuideCreateComponent extends Component
{
    use WithFileUploads;

    /* --- поля формы --- */
    public $name, $description, $specialization, $experience_years = 0;
    public $sort_order = 0, $is_active = true;
    public $languages = [];
    public $newCode = '', $newName = '';
    public $image;                      // временное поле загрузки

    /* --- правила --- */
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
            'image'            => 'nullable|image|max:2048',
            'languages'        => 'required|array|min:1',
            'languages.*'      => 'in:'.$codes,
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

    public function addLanguage()
    {
        $this->validate([
            'newCode' => 'required|alpha|size:2|not_in:' . implode(',', array_keys(AvailableLanguages::all())),
            'newName' => 'required|string|max:30',
        ], [
            'not_in' => 'Такой код уже существует'
        ]);

        AvailableLanguages::add(strtolower($this->newCode), $this->newName);
        $this->reset('newCode', 'newName');
    }

    public function deleteLanguage(string $code)
    {
        if (in_array($code, $this->languages)) {
            $this->addError('languages', 'Сначала снимите галочку у этого языка');
            return;
        }
        AvailableLanguages::remove($code);
    }

    public function mount()
    {
        $this->languages = old('languages', []);
    }

    /* --- рендер --- */
    public function render()
    {
        return view('livewire.guides.guide-create-component', [
            'availableLangs' => ['ru'=>'Русский','en'=>'English','tm'=>'Türkmen'],
        ]);
    }
}

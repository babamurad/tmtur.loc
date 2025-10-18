<?php
namespace App\Livewire\Guides;

use App\Models\Guide;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GuideEditComponent extends Component
{
    use WithFileUploads;

    public Guide $guide;          // модель
    public $name,$description,$specialization,$experience_years;
    public $sort_order,$is_active,$languages=[];
    public $newImage;             // новая картинка
    public $currentImage;         // путь к старой

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
            'newImage'         => 'nullable|image|max:2048',
        ];
    }

    public function mount($id)
    {
        $this->guide = Guide::findOrFail($id);

        // заполняем поля
        $this->fill($this->guide->only([
            'name','description','specialization','experience_years',
            'sort_order','is_active'
        ]));
        $this->languages  = $this->guide->languages ?? [];
        $this->currentImage = $this->guide->image;
    }

    public function save()
    {
        $this->validate();

        $data = $this->only([
            'name','description','specialization','experience_years',
            'sort_order','is_active','languages'
        ]);

        if ($this->newImage) {
            // удаляем старую, если она задана
            if ($this->currentImage) {
                Storage::disk('public_uploads')->delete($this->currentImage);
            }

            // сохраняем новую
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

    public function render()
    {
        return view('livewire.guides.guide-edit-component',[
            'availableLangs' => ['ru'=>'Русский','en'=>'English','tm'=>'Türkmen']
        ]);
    }
}

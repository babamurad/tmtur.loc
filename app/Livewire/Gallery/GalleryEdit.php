<?php

namespace App\Livewire\Gallery;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\TurkmenistanGallery;

class GalleryEdit extends Component
{
    use WithFileUploads;

    public TurkmenistanGallery $photo; // текущая запись

    /* редактируемые поля */
    public string $title        = '';
    public string $description  = '';
    public string $location     = '';
    public string $photographer = '';
    public string $alt_text     = '';
    public int    $order        = 0;
    public bool   $is_featured  = false;

    /* новый файл (если пользователь загрузит) */
    public $newPhoto = null;

    /* правила */
    protected function rules(): array
    {
        return [
            'title'        => 'required|min:3|max:255',
            'description'  => 'nullable|string',
            'location'     => 'nullable|string|max:255',
            'photographer' => 'nullable|string|max:255',
            'alt_text'     => 'nullable|string|max:255',
            'order'        => 'integer|min:0',
            'is_featured'  => 'boolean',
            'newPhoto'     => 'nullable|image|max:2048',
        ];
    }

    /* загружаем данные */
    public function mount(int $id): void
    {
        $this->photo = TurkmenistanGallery::findOrFail($id);

        $this->title        = $this->photo->title;
        $this->description  = $this->photo->description ?? '';
        $this->location     = $this->photo->location ?? '';
        $this->photographer = $this->photo->photographer ?? '';
        $this->alt_text     = $this->photo->alt_text ?? '';
        $this->order        = $this->photo->order;
        $this->is_featured  = $this->photo->is_featured;
    }

    /* сохранение */
    public function save()
    {
        $this->validate();

        /* если загружен новый файл – заменяем */
        if ($this->newPhoto) {
            /* удаляем старый */
            if ($this->photo->file_path) {
                Storage::disk('public_uploads')->delete($this->photo->file_path);
            }

            $path      = $this->newPhoto->store('gallery', 'public_uploads');
            $fileName  = $this->newPhoto->getClientOriginalName();
            $mime      = $this->newPhoto->getMimeType();
            $size      = $this->newPhoto->getSize();

            $this->photo->update([
                'file_path' => $path,
                'file_name' => $fileName,
                'mime_type' => $mime,
                'size'      => $size,
            ]);
        }

        /* обновляем остальные поля */
        $this->photo->update([
            'title'        => $this->title,
            'description'  => $this->description,
            'location'     => $this->location,
            'photographer' => $this->photographer,
            'alt_text'     => $this->alt_text,
            'order'        => $this->order,
            'is_featured'  => $this->is_featured,
        ]);

        session()->flash('saved', ['title' => 'Фото обновлено!', 'text' => '']);
        return redirect()->route('gallery.index');
    }

    /* рендер */
    public function render()
    {
        return view('livewire.gallery.gallery-edit');
    }
}

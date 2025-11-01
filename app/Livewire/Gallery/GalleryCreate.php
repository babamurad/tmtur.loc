<?php

namespace App\Livewire\Gallery;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\TurkmenistanGallery;
use Illuminate\Validation\Rule;

class GalleryCreate extends Component
{
    use WithFileUploads;

    /* основные поля */
    public string $title        = '';
    public string $description  = '';
    public string $location     = '';
    public string $photographer = '';
    public string $alt_text     = '';
    public int    $order        = 0;
    public bool   $is_featured  = false;

    /* загружаемый файл */
    public $photo;

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
            'photo'        => 'required|image|max:2048', // 2 МБ
        ];
    }

    /* сохранение */
    public function save()
    {
        $this->validate();

        /* загрузка файла */
        $path      = $this->photo->store('gallery', 'public_uploads');
        $fileName  = $this->photo->getClientOriginalName();
        $mime      = $this->photo->getMimeType();
        $size      = $this->photo->getSize();

        /* запись в БД */
        TurkmenistanGallery::create([
            'title'        => $this->title,
            'slug'         => Str::slug($this->title),
            'description'  => $this->description,
            'file_path'    => $path,
            'file_name'    => $fileName,
            'mime_type'    => $mime,
            'size'         => $size,
            'alt_text'     => $this->alt_text,
            'location'     => $this->location,
            'photographer' => $this->photographer,
            'order'        => $this->order,
            'is_featured'  => $this->is_featured,
        ]);

        session()->flash('saved', ['title' => 'Фото добавлено!', 'text' => '']);
        return redirect()->route('gallery.index');
    }

    /* рендер */
    public function render()
    {
        return view('livewire.gallery.gallery-create');
    }
}

<?php

namespace App\Livewire\Posts;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostEditComponent extends Component
{
    use WithFileUploads;

    public Post $post;
    public string $title;
    public string $slug;
    public int $category_id;
    public string $content;
    public bool $status;
    public string $published_at;
    public $newImage;
    public string $currentImage = '';
    public int $uploadProgress = 0;

    protected $listeners = ['upload:progress' => 'updateUploadProgress'];

    public function updateUploadProgress($progress)
    {
        $this->uploadProgress = $progress;
    }

    public function updatedTitle($value)
    {
        $this->slug = \Illuminate\Support\Str::slug($value);
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:posts,title,' . $this->post->id,
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $this->post->id,
            'category_id' => 'required|exists:categories,id',
            'content' => 'nullable|string',
            'status' => 'boolean',
            'published_at' => 'nullable|date',
            'newImage' => 'nullable|image|max:2048',
        ];
    }

    public function mount($id)
    {
        $this->post = Post::findOrFail($id);
        $this->title = $this->post->title;
        $this->slug = $this->post->slug;
        $this->category_id = $this->post->category_id;
        $this->content = $this->post->content ?? '';
        $this->status = (bool)$this->post->status;
        $this->published_at = $this->post->published_at->format('Y-m-d\TH:i');
        $this->currentImage = $this->post->image;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'slug' => $this->slug ?: \Illuminate\Support\Str::slug($this->title),
            'category_id' => $this->category_id,
            'content' => $this->content,
            'status' => $this->status,
            'published_at' => $this->published_at,
        ];

        // Обработка загрузки изображения
        if ($this->newImage) {
            // Удаляем старое изображение, если оно есть
            if ($this->currentImage) {
                \Illuminate\Support\Facades\Storage::disk('public_uploads')->delete($this->currentImage);
            }

            // Сохраняем новое изображение
            $data['image'] = $this->newImage->store('posts', 'public_uploads');
        }

        // Обновляем запись
        $this->post->update($data);

        session()->flash('message', 'Пост успешно обновлен.');
        return redirect()->route('posts.index');
    }
    public function render()
    {
        return view('livewire.posts.post-edit-component', [
            'categories' => \App\Models\Category::where('is_published', 1)->get(),
        ]);
    }
}

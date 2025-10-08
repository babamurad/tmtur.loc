<?php

namespace App\Livewire\Posts;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class PostCreateComponent extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $slug = '';
    public int $category_id = 0;
    public string $content = '';
    public bool $status = true;
    public string $published_at = '';
    public $image;
    public int $uploadProgress = 0;

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:posts',
            'slug'  => 'nullable|string|max:255|unique:posts',
            'category_id' => 'required|exists:categories,id',
            'content' => 'nullable|string',
            'status' => 'boolean',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function updatedTitle($v): void
    {
        $this->slug = \Str::slug($v);
    }

    public function mount()
    {
        $this->published_at = now()->format('Y-m-d\TH:i');
    }

    protected $listeners = ['upload:progress' => 'updateUploadProgress'];

    public function updateUploadProgress($p)
    {
        $this->uploadProgress = $p;
    }

    public function save()
    {
        $this->validate();

        $path = null;
        if ($this->image) {
            $path = $this->image->store('posts', 'public');
        }

        Post::create([
            'title' => $this->title,
            'slug'  => $this->slug ?: \Str::slug($this->title),
            'category_id' => $this->category_id,
            'content' => $this->content,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'image' => $path,
        ]);

        session()->flash('success', 'Пост создан.');
        return $this->redirectRoute('posts.index');
    }

    public function render()
    {
        return view('livewire.posts.post-create-component', [
            'categories' => Category::where('is_published', 1)->get(),
        ]);
    }
}

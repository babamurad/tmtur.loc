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
    public int $uploadProgress = 0;

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:posts,title,'.$this->post->id,
            'slug'  => 'nullable|string|max:255|unique:posts,slug,'.$this->post->id,
            'category_id' => 'required|exists:categories,id',
            'content' => 'nullable|string',
            'status' => 'boolean',
            'published_at' => 'nullable|date',
            'newImage' => 'nullable|image|max:2048',
        ];
    }

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->category_id = $post->category_id;
        $this->content = $post->content ?? '';
        $this->status = (bool)$post->status;
        $this->published_at = $post->published_at->format('Y-m-d\TH:i');
    }

    public function updatedTitle($v)
    {
        $this->slug = \Str::slug($v);
    }

    protected $listeners = ['upload:progress' => 'updateUploadProgress'];

    public function updateUploadProgress($p)
    {
        $this->uploadProgress = $p;
    }

    public function save()
    {
        $this->validate();

        if ($this->newImage) {
            $this->post->image && \Storage::disk('public')->delete($this->post->image);
            $this->post->image = $this->newImage->store('posts', 'public');
        }

        $this->post->update([
            'title' => $this->title,
            'slug'  => $this->slug ?: \Str::slug($this->title),
            'category_id' => $this->category_id,
            'content' => $this->content,
            'status' => $this->status,
            'published_at' => $this->published_at,
        ]);

        session()->flash('success', 'Пост обновлён.');
        return $this->redirectRoute('posts.index');
    }

    public function render()
    {
        return view('livewire.posts.post-edit-component', [
            'categories' => Category::where('is_published', 1)->get(),
        ]);
    }
}

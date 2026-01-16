<?php

namespace App\Livewire\Posts;

use App\Models\Category;
use App\Models\Post;
use App\Services\ImageService;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostEditComponent extends Component
{
    use WithFileUploads;

    public Post $post;
    public string $title;
    public string $slug;
    public int $category_id;
    public bool $status;
    public string $published_at;
    public $newImage;
    public string $currentImage = '';
    public int $uploadProgress = 0;
    public array $trans = [];

    protected $listeners = [
        'upload:progress' => 'updateUploadProgress',
        'quillUpdated' => 'updateQuillField'
    ];

    public function updateUploadProgress($progress)
    {
        $this->uploadProgress = $progress;
    }

    public function updateQuillField($data)
    {
        data_set($this, $data['field'], $data['value']);
    }

    public function updatedTitle($value)
    {
        $this->slug = \Illuminate\Support\Str::slug($value);
    }

    protected function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255|unique:posts,title,' . $this->post->id,
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $this->post->id,
            'category_id' => 'required|exists:categories,id',
            'status' => 'boolean',
            'published_at' => 'nullable|date',
            'newImage' => 'nullable|image|max:4096',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.content"] = 'nullable|string';
        }

        return $rules;
    }

    public function mount($id)
    {
        $this->post = Post::findOrFail($id);
        $this->title = $this->post->title;
        $this->slug = $this->post->slug;
        $this->category_id = $this->post->category_id;
        $this->status = (bool) $this->post->status;
        $this->published_at = $this->post->published_at->format('Y-m-d\TH:i');
        $this->currentImage = $this->post->image;

        // Загружаем переводы
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = $this->post->tr('title', $locale);
            $this->trans[$locale]['content'] = $this->post->tr('content', $locale);
        }
    }

    public function save()
    {
        $fallback = config('app.fallback_locale');

        // Sync fallback locale data from trans array to main model fields
        $this->title = $this->trans[$fallback]['title'] ?? $this->title;
        $this->content = $this->trans[$fallback]['content'] ?? '';

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
            $imageService = new ImageService();
            if ($this->currentImage) {
                $imageService->delete($this->currentImage);
            }

            // Сохраняем новое изображение
            $optimized = $imageService->saveOptimized($this->newImage, 'posts');
            $data['image'] = $optimized['path'];
        }

        // Обновляем запись
        $this->post->update($data);

        // Сохраняем переводы
        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $this->post->setTr($field, $locale, $value);
            }
        }

        session()->flash('saved', ['title' => 'Пост сохранён!', 'text' => 'Изменения сохранились!']);
        return redirect()->route('posts.index');
    }

    public function render()
    {
        return view('livewire.posts.post-edit-component', [
            'categories' => \App\Models\Category::where('is_published', 1)->get(),
        ]);
    }
}

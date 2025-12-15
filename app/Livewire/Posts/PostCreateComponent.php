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
    public array $trans = [];
    public int $uploadProgress = 0;

    protected $listeners = ['quillUpdated' => 'updateQuillField', 'upload:progress' => 'updateUploadProgress'];

    public function updateQuillField($data)
    {
        data_set($this, $data['field'], $data['value']);
    }

    protected function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255|unique:posts',
            'slug'  => 'nullable|string|max:255|unique:posts',
            'category_id' => 'required|exists:categories,id',
            'content' => 'nullable|string',
            'status' => 'boolean',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.title"] = 'nullable|string|max:255';
            $rules["trans.$l.content"] = 'nullable|string';
        }

        return $rules;
    }

    public function updatedTitle($v): void
    {
        $this->slug = \Str::slug($v);
    }

    public function mount()
    {
        $this->published_at = now()->format('Y-m-d\TH:i');
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['title'] = '';
            $this->trans[$locale]['content'] = '';
        }
    }

    public function updateUploadProgress($p)
    {
        $this->uploadProgress = $p;
    }

    public function save()
    {
        $fallback = config('app.fallback_locale');
        
        // Sync fallback locale data from trans array to main model fields
        $this->title = $this->trans[$fallback]['title'] ?? '';
        $this->content = $this->trans[$fallback]['content'] ?? '';

        \Log::info('Начало создания поста', ['title' => $this->title]);

        try {
            // Валидация данных
            $validatedData = $this->validate();
            \Log::debug('Валидация пройдена', $validatedData);

            // Обработка загрузки изображения
            $path = null;
            if ($this->image) {
                \Log::debug('Начало загрузки изображения');
                $path = $this->image->storeAs(
                    'posts',
                    \Illuminate\Support\Str::uuid() . '.' . $this->image->extension(),
                    'public_uploads'
                );
                \Log::debug('Изображение загружено', ['path' => $path]);
            }

            // Подготовка данных для создания поста
            $postData = [
                'title' => $this->title,
                'slug' => $this->slug ?: \Str::slug($this->title),
                'category_id' => (int)$this->category_id,
                'content' => $this->content,
                'status' => (bool)$this->status,
                'published_at' => $this->published_at,
                'image' => $path,
                'user_id' => auth()->id(),
            ];

            \Log::debug('Данные для создания поста', $postData);

            // Создание поста с обработкой исключений
            $post = new Post();
            $post->fill($postData);
            $saved = $post->save();

            if (!$saved) {
                throw new \Exception('Не удалось сохранить пост в базу данных');
            }

            // Сохраняем переводы
            foreach ($this->trans as $locale => $fields) {
                foreach ($fields as $field => $value) {
                    $post->setTr($field, $locale, $value);
                }
            }

            \Log::info('Пост успешно создан', [
                'post_id' => $post->id,
                'post_data' => $post->toArray()
            ]);

            session()->flash('saved', ['title' => 'Пост сохранён!', 'text' => 'Создан новый пост!']);
            return $this->redirectRoute('posts.index');

        } catch (\Exception $e) {
            \Log::error('Ошибка при создании поста', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'input_data' => [
                    'title' => $this->title,
                    'slug' => $this->slug,
                    'category_id' => $this->category_id,
                    'content' => $this->content,
                    'status' => $this->status,
                    'published_at' => $this->published_at,
                    'image' => $path ?? null,
                ]
            ]);

            session()->flash('error', 'Произошла ошибка при создании поста: ' . $e->getMessage());
            return;
        }
    }

    public function render()
    {
        return view('livewire.posts.post-create-component', [
            'categories' => Category::where('is_published', 1)->get(),
        ]);
    }
}

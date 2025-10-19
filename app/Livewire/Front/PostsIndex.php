<?php

namespace App\Livewire\Front;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostsIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $categorySlug = null;

    public function mount($categorySlug = null)
    {
        $this->categorySlug = $categorySlug;
    }

    public function render()
    {
        $posts = Post::query()
            ->when($this->categorySlug, function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('slug', $this->categorySlug);
                });
            })
            ->where('status', true)
            ->orderBy('published_at', 'desc')
            ->paginate(2);

        $categories = Category::withCount('posts')->where('is_published', true)->get();

        return view('livewire.front.posts-index', [
            'posts' => $posts,
            'categories' => $categories,
        ])->layout('layouts.front-app');
    }
}

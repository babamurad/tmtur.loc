<?php

namespace App\Livewire\Front;

use App\Models\Post;
use Livewire\Component;

class PostShow extends Component
{
    public $post;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->post->increment('views');
    }

    public function render()
    {
        $categories = \App\Models\Category::withCount('posts')->where('is_published', true)->get();

        return view('livewire.front.post-show', [
            'categories' => $categories,
        ])->layout('layouts.front-app');
    }
}
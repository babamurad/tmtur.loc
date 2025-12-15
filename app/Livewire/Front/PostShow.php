<?php

namespace App\Livewire\Front;

use App\Models\Post;
use App\Models\SocialLink;
use Livewire\Component;

class PostShow extends Component
{
    public $post;

    public function mount(Post $post)
    {
        $this->post = $post->load('user.avatar');
        $this->post->increment('views');
    }

    public function render()
    {
        $categories = \App\Models\Category::withCount('posts')->where('is_published', true)->get();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();

        return view('livewire.front.post-show', [
            'categories' => $categories,
            'socialLinks' => $socialLinks,
        ])
            ->layout('layouts.front-app', ['hideCarousel' => true])
            ->title(__('titles.post_show', ['post' => $this->post->tr('title')]));
    }
}
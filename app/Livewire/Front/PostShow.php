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

        $title = $this->post->tr('title');
        \Artesaos\SEOTools\Facades\SEOTools::setTitle($title);
        \Artesaos\SEOTools\Facades\SEOTools::setDescription($this->post->tr('excerpt') ?? $title);
        \Artesaos\SEOTools\Facades\SEOTools::opengraph()->setUrl(route('blog.show', $this->post->slug));

        // Add image if exists (assuming 'image' field)
        if ($this->post->image) {
            \Artesaos\SEOTools\Facades\SEOTools::opengraph()->addImage(asset('storage/' . $this->post->image));
        }

        return view('livewire.front.post-show', [
            'categories' => $categories,
            'socialLinks' => $socialLinks,
        ])
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}
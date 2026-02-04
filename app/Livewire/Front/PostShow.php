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
        $this->post = $post->load(['user.avatar', 'translations']);
        $this->post->increment('views');
    }

    public function render()
    {
        $categories = \Illuminate\Support\Facades\Cache::remember('categories_with_counts', 3600, function () {
            return \App\Models\Category::withCount('posts')->with('translations')->where('is_published', true)->get();
        });

        $socialLinks = \Illuminate\Support\Facades\Cache::remember('social_links', 86400, function () {
            return SocialLink::where('is_active', true)->orderBy('sort_order')->get();
        });

        $popularPosts = \Illuminate\Support\Facades\Cache::remember('popular_posts_sidebar', 3600, function () {
            return Post::select('id', 'slug', 'image', 'status', 'views', 'published_at')
                ->with([
                    'translations' => function ($query) {
                        $query->where('field', 'title');
                    }
                ])
                ->where('status', true)
                ->orderBy('views', 'desc')
                ->take(5)
                ->get();
        });

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
            'popularPosts' => $popularPosts,
        ])
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FrontPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully_with_empty_catalog(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Our popular tours', false);
    }

    public function test_blog_listing_displays_published_posts(): void
    {
        $category = \App\Models\Category::create([
            'title' => 'Culture',
            'content' => 'Culture description',
            'image' => null,
            'is_published' => true,
        ]);

        $post = \App\Models\Post::create([
            'title' => 'Amazing desert trip',
            'category_id' => $category->id,
            'content' => 'Post body',
            'image' => null,
            'status' => true,
            'published_at' => now(),
        ]);

        $response = $this->get(route('blog.index'));

        $response->assertOk();
        $response->assertSee($post->title, false);
    }
}

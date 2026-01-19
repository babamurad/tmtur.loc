<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Tour;
use App\Models\Post;
use App\Models\TourCategory;
use App\Models\Category;
use App\Models\Tag;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml for the site';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating sitemap...');

        // Force production URL for sitemap
        \Illuminate\Support\Facades\URL::forceRootUrl('https://tmtourism.com');
        \Illuminate\Support\Facades\URL::forceScheme('https');

        $sitemap = Sitemap::create();

        // 1. Static pages
        $sitemap->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $sitemap->add(Url::create(route('about'))->setPriority(0.8));
        $sitemap->add(Url::create(route('visa'))->setPriority(0.8));
        $sitemap->add(Url::create(route('gallery'))->setPriority(0.8));
        $sitemap->add(Url::create(route('blog.index'))->setPriority(0.8));
        $sitemap->add(Url::create(route('front.tour-groups'))->setPriority(0.8)); // Calendar/Groups page

        // 2. Tours
        $tours = Tour::where('is_published', true)->get();
        foreach ($tours as $tour) {
            $sitemap->add(
                Url::create(route('tours.show', $tour->slug))
                    ->setLastModificationDate($tour->updated_at)
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        }

        // 3. Posts (Blog)
        $posts = Post::where('status', true)->get();
        foreach ($posts as $post) {
            $sitemap->add(
                Url::create(route('blog.show', $post->slug))
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(0.7)
            );
        }

        // 4. Tour Categories
        $tourCategories = TourCategory::where('is_published', true)->get();
        foreach ($tourCategories as $category) {
            $sitemap->add(
                Url::create(route('tours.category.show', $category->slug))
                    ->setLastModificationDate($category->updated_at)
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        }

        // 5. Blog Categories
        $blogCategories = Category::where('is_published', true)->get();
        foreach ($blogCategories as $category) {
            $sitemap->add(
                Url::create(route('blog.category', $category->slug))
                    ->setLastModificationDate($category->updated_at)
                    ->setPriority(0.7)
            );
        }

        // 6. Tags (Only those with tours)
        $tags = Tag::has('tours')->get();
        foreach ($tags as $tag) {
            $sitemap->add(
                Url::create(route('tours.tag.show', $tag->id))
                    ->setLastModificationDate($tag->updated_at)
                    ->setPriority(0.6)
            );
        }

        // 7. Static Pages (Legal)
        $sitemap->add(Url::create(route('privacy'))->setPriority(0.5));
        $sitemap->add(Url::create(route('terms'))->setPriority(0.5));
        $sitemap->add(Url::create(route('tours.category.index'))->setPriority(0.8)); // All Categories

        // Save to file
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully: ' . public_path('sitemap.xml'));

        return self::SUCCESS;
    }
}

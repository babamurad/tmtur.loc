<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Tour;
use App\Models\Post;

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

        // Save to file
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully: ' . public_path('sitemap.xml'));

        return self::SUCCESS;
    }
}

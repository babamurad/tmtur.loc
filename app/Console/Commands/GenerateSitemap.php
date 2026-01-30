<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Tour;
use App\Models\TourCategory;
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
    protected $description = 'Generate the sitemap.xml file including all localized links';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting sitemap generation...');

        $sitemap = Sitemap::create();
        $locales = config('app.available_locales', ['en']);
        // Remove 'en' from explicit params if we want / to be English. 
        // But for clarity let's just add all params including ?lang=en to be sure, 
        // OR rely on x-default.
        // Strategy: / is main, /?lang=ru is alternative. 
        // We should add / (default) AND /?lang=xx for OTHERS. 
        // If we add /?lang=en, it's a duplicate of /. 
        // Let's assume 'en' is default.

        $defaultLocale = 'en'; // Should match app.fallback_locale

        // Standard Static Routes
        $staticRoutes = [
            'home',
            'about',
            'tours.category.index',
            'blog.index',
            'visa',
            'gallery',
            'reviews.index',
        ];

        foreach ($staticRoutes as $routeName) {
            try {
                $url = route($routeName);
                $this->addLocalizedUrls($sitemap, $url, $locales, $defaultLocale);
            } catch (\Exception $e) {
                $this->warn("Route $routeName not found or error: " . $e->getMessage());
            }
        }

        // Tours
        $this->info('Indexing Tours...');
        Tour::where('is_published', true)->chunk(100, function ($tours) use ($sitemap, $locales, $defaultLocale) {
            foreach ($tours as $tour) {
                $url = route('tours.show', $tour->slug);
                $this->addLocalizedUrls($sitemap, $url, $locales, $defaultLocale, 0.8, $tour->updated_at);
            }
        });

        // Categories
        $this->info('Indexing Categories...');
        TourCategory::where('is_published', true)->chunk(100, function ($categories) use ($sitemap, $locales, $defaultLocale) {
            foreach ($categories as $category) {
                $url = route('tours.category.show', $category->slug);
                $this->addLocalizedUrls($sitemap, $url, $locales, $defaultLocale, 0.7, $category->updated_at);
            }
        });

        // Posts
        $this->info('Indexing Posts...');
        // Assuming Post has is_published or similar
        Post::where('status', 'published')->chunk(100, function ($posts) use ($sitemap, $locales, $defaultLocale) {
            foreach ($posts as $post) {
                $url = route('blog.show', $post->slug);
                $this->addLocalizedUrls($sitemap, $url, $locales, $defaultLocale, 0.6, $post->updated_at);
            }
        });

        // Write to file
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }

    protected function addLocalizedUrls(Sitemap $sitemap, string $baseUrl, array $locales, string $defaultLocale, float $priority = 0.5, $updatedAt = null)
    {
        // Add default URL (no query param implies default language, typically en)
        $tag = Url::create($baseUrl)
            ->setPriority($priority);

        if ($updatedAt) {
            $tag->setLastModificationDate($updatedAt);
        }

        $sitemap->add($tag);

        // Add localized versions
        foreach ($locales as $locale) {
            if ($locale === $defaultLocale)
                continue; // Skip default to avoid duplicate of pure URL if they are same content

            // Construct URL with query param
            // Assuming no existing query params in base routes for now
            $locUrl = $baseUrl . '?lang=' . $locale;

            $locTag = Url::create($locUrl)
                ->setPriority($priority); // Maybe lower priority? No, same content just translated.

            if ($updatedAt) {
                $locTag->setLastModificationDate($updatedAt);
            }

            $sitemap->add($locTag);
        }
    }
}

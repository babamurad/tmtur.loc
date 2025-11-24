<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    // Имя команды, которой будете пользоваться
    protected $signsture = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        // В .env у вас должен быть APP_URL=https://tmtourism.com
        $baseUrl = config('app.url');

        // sitemap будет лежать в public/sitemap.xml
        SitemapGenerator::create($baseUrl)->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated: ' . public_path('sitemap.xml'));

        return self::SUCCESS;
    }
}

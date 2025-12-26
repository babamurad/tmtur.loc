<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CarouselSlide;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegenerateCarouselImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:regenerate-carousel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate mobile variants for existing carousel images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting regeneration of carousel images mobile variants...');

        $slides = CarouselSlide::all();
        $manager = new ImageManager(new Driver());
        $disk = Storage::disk('public_uploads');

        $count = 0;

        foreach ($slides as $slide) {
            if (!$slide->image) {
                continue;
            }

            // Check if original file exists
            if (!$disk->exists($slide->image)) {
                $this->error("Original image not found for slide ID: {$slide->id} ({$slide->image})");
                continue;
            }

            try {
                $this->line("Processing slide ID: {$slide->id}...");

                // Read original
                $originalPath = $disk->path($slide->image);
                $fileBasename = pathinfo($slide->image, PATHINFO_FILENAME);
                $folder = dirname($slide->image);
                $folder = $folder === '.' ? '' : $folder . '/';

                // We need to read the image once
                $image = $manager->read($originalPath);

                // 1. Mobile Variant (WebP, 600px)
                $mobileImageName = $folder . $fileBasename . '_mobile.webp';
                $imgMobile = clone $image;
                $imgMobile->scale(width: 600);
                $imgMobile->toWebp()->save($disk->path($mobileImageName));
                $this->info("Generated: {$mobileImageName}");

                // 2. Desktop Variant (WebP, 1920px)
                $desktopImageName = $folder . $fileBasename . '_desktop.webp';
                $imgDesktop = clone $image;
                $imgDesktop->scale(width: 1920);
                $imgDesktop->toWebp()->save($disk->path($desktopImageName));
                $this->info("Generated: {$desktopImageName}");

                $count++;
            } catch (\Exception $e) {
                $this->error("Failed to process slide ID: {$slide->id}. Error: " . $e->getMessage());
            }
        }

        $this->info("Done! Processed {$count} images.");
    }
}

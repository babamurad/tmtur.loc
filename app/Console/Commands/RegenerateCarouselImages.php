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

            // Construct mobile path
            $mobileImage = Str::replaceLast('.', '_mobile.', $slide->image);

            // Skip if already exists (optional, but good for idempotency)
            // if ($disk->exists($mobileImage)) {
            //     $this->line("Mobile variant already exists for slide ID: {$slide->id}");
            //     continue;
            // }

            try {
                $this->line("Processing slide ID: {$slide->id}...");

                // Read original
                $originalPath = $disk->path($slide->image);
                $image = $manager->read($originalPath);

                // Resize
                $image->scale(width: 600);

                // Save mobile variant
                $image->save($disk->path($mobileImage));

                $this->info("Generated: {$mobileImage}");
                $count++;
            } catch (\Exception $e) {
                $this->error("Failed to process slide ID: {$slide->id}. Error: " . $e->getMessage());
            }
        }

        $this->info("Done! Processed {$count} images.");
    }
}

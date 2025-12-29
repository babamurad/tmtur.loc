<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageOptimizationTest extends TestCase
{
    public function test_image_is_optimized_resized_and_converted_to_webp()
    {
        Storage::fake('public_uploads');

        // Create a fake image larger than 1200px
        // creating a 1500x1500 image
        $file = UploadedFile::fake()->image('test_image.jpg', 1500, 1500);

        $service = new ImageService();
        $result = $service->saveOptimized($file, 'test_folder', 'public_uploads');

        // Assert file was stored
        Storage::disk('public_uploads')->assertExists($result['path']);

        // Assert file name ends with .webp
        $this->assertStringEndsWith('.webp', $result['file_path'] ?? $result['path']);
        $this->assertEquals('image/webp', $result['mime_type']);

        // Check actual file content
        $fullPath = Storage::disk('public_uploads')->path($result['path']);

        $manager = new ImageManager(new Driver());
        $image = $manager->read($fullPath);

        // Assert width is resized to 1200
        $this->assertEquals(1200, $image->width());

        // Assert height preserved aspect ratio (1500x1500 -> 1200x1200)
        $this->assertEquals(1200, $image->height());
    }

    public function test_small_image_is_converted_but_not_upscaled()
    {
        Storage::fake('public_uploads');

        // Create a small image
        $file = UploadedFile::fake()->image('small.jpg', 800, 600);

        $service = new ImageService();
        $result = $service->saveOptimized($file, 'test_folder', 'public_uploads');

        Storage::disk('public_uploads')->assertExists($result['path']);

        $fullPath = Storage::disk('public_uploads')->path($result['path']);
        $manager = new ImageManager(new Driver());
        $image = $manager->read($fullPath);

        // Assert width is STILL 800
        $this->assertEquals(800, $image->width());
    }
}

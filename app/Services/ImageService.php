<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Save original image and create a mobile resized variant.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string $disk
     * @return string The path of the saved original image (relative to the disk root)
     */
    public function saveAndResize(UploadedFile $file, string $folder, string $disk = 'public_uploads'): string
    {
        // Generate a unique filename
        $filename = $file->hashName();
        $path = $folder . '/' . $filename;

        // 1. Save Original
        // We use the Storage facade for the original to ensure it's saved correctly in the disk
        $path = $file->storeAs($folder, $filename, $disk);

        // 2. Create and Save Mobile Variant
        // Resize to width 600px, constrain aspect ratio
        $image = $this->manager->read($file->getRealPath());
        $image->scale(width: 600);

        $mobileFilename = pathinfo($filename, PATHINFO_FILENAME) . '_mobile.' . $file->getClientOriginalExtension();
        $mobilePath = $folder . '/' . $mobileFilename;

        // We need to save the modified image to the same disk structure
        // Since Intervention 3 saves to filesystem path, we'll get the disk's root path
        $fullPath = Storage::disk($disk)->path($mobilePath);
        
        $image->save($fullPath);

        return $path;
    }

    /**
     * Delete image and its variants.
     * 
     * @param string $path
     * @param string $disk
     */
    public function delete(string $path, string $disk = 'public_uploads')
    {
        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }

        // Try to delete mobile variant
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $directory = dirname($path);
        
        // Handle case where dirname is '.' or empty (though typically it will include the folder)
        $directory = $directory === '.' ? '' : $directory . '/';

        $mobilePath = $directory . $filename . '_mobile.' . $extension;

        if (Storage::disk($disk)->exists($mobilePath)) {
            Storage::disk($disk)->delete($mobilePath);
        }
    }
}

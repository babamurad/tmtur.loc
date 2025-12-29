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
     * Save original image and create optimized WebP variants.
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
        // 1. Save Original (as fallback and source of truth)
        $path = $file->storeAs($folder, $filename, $disk);

        // Process variants
        $manager = new ImageManager(new Driver());
        // Read image from the stored file to ensure we work with what's on disk (or temp file)
        // Using getRealPath() from uploaded file is safer/faster before it's moved? 
        // storeAs moves it? No, storeAs copies usually or moves. 
        // UploadedFile object points to php temp.
        $image = $manager->read($file->getRealPath());

        $fileBasename = pathinfo($filename, PATHINFO_FILENAME);

        // 2. Mobile Variant (WebP, 600px)
        $imgMobile = clone $image;
        $imgMobile->scale(width: 600);
        $mobilePath = $folder . '/' . $fileBasename . '_mobile.webp';
        $fullMobilePath = Storage::disk($disk)->path($mobilePath);
        $imgMobile->toWebp()->save($fullMobilePath);

        // 3. Desktop Variant (WebP, 1920px max)
        $imgDesktop = clone $image;
        $imgDesktop->scale(width: 1920);

        $desktopPath = $folder . '/' . $fileBasename . '_desktop.webp';
        $fullDesktopPath = Storage::disk($disk)->path($desktopPath);
        $imgDesktop->toWebp()->save($fullDesktopPath);

        return $path;
    }

    /**
     * Save image with optimization: Resize to max 1200px width, convert to WebP, compress.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string $disk
     * @return array {path, filename, mime_type}
     */
    public function saveOptimized(UploadedFile $file, string $folder, string $disk = 'public_uploads'): array
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());

        // Optimize: Scale to max width 1200px, resize only if larger
        if ($image->width() > 1200) {
            $image->scale(width: 1200);
        }

        // Generate filename with .webp extension
        $filename = pathinfo($file->hashName(), PATHINFO_FILENAME) . '.webp';
        $path = $folder . '/' . $filename;

        // Ensure directory exists - Storage::put handles this but verify just in case not needed for put
        $fullPath = Storage::disk($disk)->path($path);

        // Ensure the directory exists
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save as WebP with 80% quality
        $image->toWebp(quality: 80)->save($fullPath);

        return [
            'path' => $path,
            'file_name' => $filename,
            'mime_type' => 'image/webp',
            'size' => filesize($fullPath), // Get actual size of the new file
        ];
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

        // Delete variants
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $directory = dirname($path);
        $directory = $directory === '.' ? '' : $directory . '/';

        // Legacy mobile (if exists)
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $legacyMobile = $directory . $filename . '_mobile.' . $extension;
        if (Storage::disk($disk)->exists($legacyMobile)) {
            Storage::disk($disk)->delete($legacyMobile);
        }

        // WebP Variants
        $mobileWebp = $directory . $filename . '_mobile.webp';
        if (Storage::disk($disk)->exists($mobileWebp)) {
            Storage::disk($disk)->delete($mobileWebp);
        }

        $desktopWebp = $directory . $filename . '_desktop.webp';
        if (Storage::disk($disk)->exists($desktopWebp)) {
            Storage::disk($disk)->delete($desktopWebp);
        }
    }
}

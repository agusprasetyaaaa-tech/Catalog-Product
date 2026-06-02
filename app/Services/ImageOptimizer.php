<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageOptimizer
{
    /**
     * Optimize an uploaded image: resize, compress, convert to WebP.
     *
     * @param  UploadedFile  $file
     * @return array{path: string, size_kb: int, original_filename: string}
     */
    public function optimize(UploadedFile $file): array
    {
        $mimeType = $file->getMimeType();
        $originalName = $file->getClientOriginalName();

        // If it's an SVG file, bypass raster optimization to preserve vector geometry and scalability
        if ($mimeType === 'image/svg+xml' || Str::endsWith(strtolower($originalName), '.svg')) {
            $filename = Str::uuid()->toString() . '.svg';
            $path = 'products/' . $filename;

            // Store the raw vector content directly
            Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
            $sizeKb = (int) ceil(Storage::disk('public')->size($path) / 1024);

            return [
                'path' => $path,
                'size_kb' => $sizeKb,
                'original_filename' => $originalName,
            ];
        }

        // If it's a PDF file, bypass raster optimization to preserve document format
        if ($mimeType === 'application/pdf' || Str::endsWith(strtolower($originalName), '.pdf')) {
            $filename = Str::uuid()->toString() . '.pdf';
            $path = 'products/' . $filename;

            // Store the raw PDF content directly
            Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
            $sizeKb = (int) ceil(Storage::disk('public')->size($path) / 1024);

            // Generate thumbnail of first page immediately
            try {
                $fullPdfPath = Storage::disk('public')->path($path);
                $thumbnailPrefix = str_replace('.pdf', '_thumbnail', $fullPdfPath);

                // Run pdftoppm to extract first page as PNG
                $cmd = "pdftoppm -png -f 1 -l 1 -r 150 " . escapeshellarg($fullPdfPath) . " " . escapeshellarg($thumbnailPrefix);
                shell_exec($cmd);

                $tempPngPath = $thumbnailPrefix . '-1.png';

                if (file_exists($tempPngPath)) {
                    // Use Intervention Image to convert the extracted PNG to WebP
                    $img = Image::read($tempPngPath);
                    $img->scaleDown(width: 800);

                    $webpPath = str_replace('.pdf', '_thumbnail.webp', $path);
                    $webpData = $img->toWebp(quality: 90);

                    Storage::disk('public')->put($webpPath, (string) $webpData);
                    unlink($tempPngPath);
                }
            } catch (\Exception $e) {
                logger()->error("PDF thumbnail generation failed: " . $e->getMessage());
            }

            return [
                'path' => $path,
                'size_kb' => $sizeKb,
                'original_filename' => $originalName,
            ];
        }

        // Read raster image using Intervention Image v3
        $image = Image::read($file->getRealPath());

        // Scale down to max 2048px width (2K retina sharpness), maintaining aspect ratio
        $image->scaleDown(width: 2048);

        // Generate unique filename with WebP extension
        $filename = Str::uuid()->toString() . '.webp';
        $path = 'products/' . $filename;

        // Encode to WebP with 92% quality (excellent high-fidelity balance for maximum crispness)
        $encoded = $image->toWebp(quality: 92);

        // Store the optimized image
        Storage::disk('public')->put($path, (string) $encoded);

        // Calculate file size in KB
        $sizeKb = (int) ceil(Storage::disk('public')->size($path) / 1024);

        return [
            'path' => $path,
            'size_kb' => $sizeKb,
            'original_filename' => $originalName,
        ];
    }

    /**
     * Delete an image from storage.
     */
    public function delete(string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

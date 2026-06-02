<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Services\ImageOptimizer;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    /**
     * After creating the product, optimize the uploaded image.
     * Converts to WebP, compresses, and updates the record.
     */
    protected function afterCreate(): void
    {
        $record = $this->record;
        $originalPath = $record->image_path;

        if ($originalPath && Storage::disk('public')->exists($originalPath)) {
            $optimizer = new ImageOptimizer();

            // Create an UploadedFile instance from the stored file
            $fullPath = Storage::disk('public')->path($originalPath);
            $tempFile = new UploadedFile(
                $fullPath,
                basename($originalPath),
                mime_content_type($fullPath),
                null,
                true // test mode to skip is_uploaded_file check
            );

            $result = $optimizer->optimize($tempFile);

            // Delete the original unoptimized file
            if ($result['path'] !== $originalPath) {
                $optimizer->delete($originalPath);
            }

            // Update record with optimized image data
            $record->update([
                'image_path' => $result['path'],
                'file_size_kb' => $result['size_kb'],
                'original_filename' => $result['original_filename'],
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

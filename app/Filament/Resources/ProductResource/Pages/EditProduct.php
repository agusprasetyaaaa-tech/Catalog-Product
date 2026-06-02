<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Services\ImageOptimizer;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    /**
     * Track the original image path before editing.
     */
    protected ?string $originalImagePath = null;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->originalImagePath = $data['image_path'] ?? null;
        return $data;
    }

    /**
     * After saving, optimize the image if it was changed.
     */
    protected function afterSave(): void
    {
        $record = $this->record;
        $currentPath = $record->image_path;

        // Only optimize if the image path has changed (new upload)
        if ($currentPath && $currentPath !== $this->originalImagePath) {
            if (Storage::disk('public')->exists($currentPath)) {
                $optimizer = new ImageOptimizer();

                $fullPath = Storage::disk('public')->path($currentPath);
                $tempFile = new UploadedFile(
                    $fullPath,
                    basename($currentPath),
                    mime_content_type($fullPath),
                    null,
                    true
                );

                $result = $optimizer->optimize($tempFile);

                // Delete the original uploaded file
                if ($result['path'] !== $currentPath) {
                    $optimizer->delete($currentPath);
                }

                // Delete the old image if it existed
                if ($this->originalImagePath && $this->originalImagePath !== $result['path']) {
                    $optimizer->delete($this->originalImagePath);
                }

                // Update record with optimized data
                $record->update([
                    'image_path' => $result['path'],
                    'file_size_kb' => $result['size_kb'],
                    'original_filename' => $result['original_filename'],
                ]);
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus Produk'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

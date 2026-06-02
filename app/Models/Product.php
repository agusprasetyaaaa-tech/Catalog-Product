<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'product_group_id',
        'name',
        'description',
        'image_path',
        'original_filename',
        'file_size_kb',
        'sort_order',
        'is_active',
        'show_description',
    ];

    protected $casts = [
        'brand_id' => 'integer',
        'product_group_id' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'file_size_kb' => 'integer',
        'show_description' => 'boolean',
    ];

    protected $appends = ['image_url', 'thumbnail_url', 'pdf_pages_urls'];

    /**
     * Scope: hanya produk yang aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor: URL lengkap ke gambar produk.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        $url = Storage::disk('public')->url($this->image_path);
        return parse_url($url, PHP_URL_PATH);
    }

    /**
     * Relasi: produk berasosiasi dengan sebuah brand.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Relasi: produk berasosiasi dengan group produk (sub-kategori).
     */
    public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class);
    }

    /**
     * Cek apakah file produk merupakan PDF.
     */
    public function isPdf(): bool
    {
        if (!$this->image_path) {
            return false;
        }

        return strtolower(pathinfo($this->image_path, PATHINFO_EXTENSION)) === 'pdf';
    }

    /**
     * Accessor: URL lengkap ke thumbnail produk (jika PDF, mengembalikan gambar halaman pertama).
     * Melakukan JIT (Just-In-Time) generation jika thumbnail belum ada di storage.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        if ($this->isPdf()) {
            $thumbnailPath = str_replace('.pdf', '_thumbnail.webp', $this->image_path);
            
            // JIT Generation if thumbnail doesn't exist (self-healing for old records)
            if (!Storage::disk('public')->exists($thumbnailPath)) {
                try {
                    $fullPdfPath = Storage::disk('public')->path($this->image_path);
                    $thumbnailPrefix = str_replace('.pdf', '_thumbnail', $fullPdfPath);

                    // Run pdftoppm to extract first page as PNG
                    $cmd = "pdftoppm -png -f 1 -l 1 -r 150 " . escapeshellarg($fullPdfPath) . " " . escapeshellarg($thumbnailPrefix);
                    shell_exec($cmd);

                    $tempPngPath = $thumbnailPrefix . '-1.png';
                    if (!file_exists($tempPngPath)) {
                        $tempPngPath = $thumbnailPrefix . '-01.png';
                    }
                    if (!file_exists($tempPngPath)) {
                        $matches = glob($thumbnailPrefix . '-*.png');
                        if (!empty($matches)) {
                            $tempPngPath = $matches[0];
                        }
                    }

                    if (file_exists($tempPngPath)) {
                        $img = \Intervention\Image\Laravel\Facades\Image::read($tempPngPath);
                        $img->scaleDown(width: 1600);
                        $webpData = $img->toWebp(quality: 95);

                        Storage::disk('public')->put($thumbnailPath, (string) $webpData);
                        unlink($tempPngPath);
                        
                        // Clean up any other leftover temporary PNG files matching prefix
                        $leftovers = glob($thumbnailPrefix . '-*.png');
                        foreach ($leftovers as $leftover) {
                            if (file_exists($leftover)) {
                                unlink($leftover);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    logger()->error("JIT PDF thumbnail generation failed: " . $e->getMessage());
                }
            }

            if (Storage::disk('public')->exists($thumbnailPath)) {
                $url = Storage::disk('public')->url($thumbnailPath);
                return parse_url($url, PHP_URL_PATH);
            }
        }

        return $this->image_url;
    }

    /**
     * Accessor: Mendapatkan list URL dari semua halaman PDF yang telah dikonversi ke WebP.
     */
    public function getPdfPagesUrlsAttribute(): array
    {
        if (!$this->isPdf() || !$this->image_path) {
            return [];
        }

        $baseName = pathinfo($this->image_path, PATHINFO_FILENAME);
        $dirName = pathinfo($this->image_path, PATHINFO_DIRNAME);
        
        // e.g. "products/abc_page_"
        $pagePatternPrefix = ($dirName === '.' ? '' : $dirName . '/') . $baseName . '_page_';
        
        $disk = Storage::disk('public');
        $publicPath = $disk->path('');
        $webpPattern = $publicPath . $pagePatternPrefix . '*.webp';
        
        $existingWebpFiles = glob($webpPattern);

        if (empty($existingWebpFiles)) {
            try {
                $fullPdfPath = $disk->path($this->image_path);
                $tempPrefix = $publicPath . $pagePatternPrefix . 'temp';

                // Run pdftoppm to extract all pages as PNG
                $cmd = "pdftoppm -png -r 150 " . escapeshellarg($fullPdfPath) . " " . escapeshellarg($tempPrefix);
                shell_exec($cmd);

                // Find all generated temporary PNG files
                $tempPngFiles = glob($tempPrefix . '-*.png');
                
                if (!empty($tempPngFiles)) {
                    // Sort naturally (so page 2 is before page 10)
                    natsort($tempPngFiles);
                    $tempPngFiles = array_values($tempPngFiles);

                    foreach ($tempPngFiles as $index => $pngPath) {
                        $pageNum = $index + 1;
                        $webpPath = $pagePatternPrefix . $pageNum . '.webp';
                        
                        // Convert to WebP using Intervention Image
                        $img = \Intervention\Image\Laravel\Facades\Image::read($pngPath);
                        $img->scaleDown(width: 1600);
                        $webpData = $img->toWebp(quality: 95);

                        $disk->put($webpPath, (string) $webpData);
                        unlink($pngPath);
                    }
                }
                
                // Clear any leftover temporary files
                $leftovers = glob($tempPrefix . '-*.png');
                foreach ($leftovers as $leftover) {
                    if (file_exists($leftover)) {
                        unlink($leftover);
                    }
                }
                
                $existingWebpFiles = glob($webpPattern);
            } catch (\Exception $e) {
                logger()->error("JIT PDF all pages generation failed: " . $e->getMessage());
            }
        }

        if (!empty($existingWebpFiles)) {
            natsort($existingWebpFiles);
            $existingWebpFiles = array_values($existingWebpFiles);
            
            $urls = [];
            foreach ($existingWebpFiles as $filePath) {
                $relativePath = str_replace($publicPath, '', $filePath);
                $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
                
                $url = $disk->url($relativePath);
                $urls[] = parse_url($url, PHP_URL_PATH);
            }
            return $urls;
        }

        return [$this->thumbnail_url];
    }
}

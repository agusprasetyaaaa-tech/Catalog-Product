<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductGroup extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'brand_id' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope: hanya group yang aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Relasi: satu group berasosiasi dengan satu brand.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Relasi: satu group memiliki banyak produk.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }
}

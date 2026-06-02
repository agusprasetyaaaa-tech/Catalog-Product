<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope: hanya brand yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Relasi: satu brand memiliki banyak produk.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relasi: satu brand memiliki banyak group/sub-kategori produk.
     */
    public function productGroups()
    {
        return $this->hasMany(ProductGroup::class)->orderBy('sort_order');
    }
}

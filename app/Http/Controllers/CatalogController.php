<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Display the public product catalog.
     * Optimized for QR code scan — fast, clean, image-focused.
     */
    public function index(): View
    {
        $brands = Brand::active()
            ->with(['productGroups' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order')->orderBy('name');
            }])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $products = Product::active()
            ->with(['brand', 'productGroup'])
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        $logoUrl = Setting::getLogoUrl();
        $heroSubtitle = Setting::get('hero_subtitle', 'Curated selection of premium products');

        return view('catalog.index', compact('brands', 'products', 'logoUrl', 'heroSubtitle'));
    }
}

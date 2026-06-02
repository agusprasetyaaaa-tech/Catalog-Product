<?php

use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Public-facing product catalog — accessible via QR code scan.
| Admin panel is handled by Filament at /admin.
|
*/

Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');

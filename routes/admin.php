<?php

use App\Http\Controllers\Admin\InventoryPageController;
use App\Http\Controllers\Inventory\BrandManagementController;
use App\Http\Controllers\Inventory\CategoryManagementController;
use App\Http\Controllers\Inventory\LocationManagementController;
use App\Http\Controllers\Inventory\ProductManagementController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
// use Laravel\Fortify\Features;

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('inventory', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('inventory');
// Route::get('inventory/products', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('products');
Route::get('inventory/categories', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('categories');

Route::prefix('inventory')->middleware('auth')->controller(InventoryPageController::class)->name('inventory-')->group(function () {
    Route::get('products', 'ProductsPage')->name('products');
    Route::get('products/create', 'ProductCreatePage')->name('products-create');
    Route::get('categories', 'CategoriesPage')->name('categories');
    Route::get('categories/create', 'CategoryCreate')->name('categories-create');
    Route::get('brands', 'BrandsPage')->name('brands');
    Route::get('brands/create', 'BrandCreate')->name('brands-create');
    Route::get('locations', 'LocationsPage')->name('locations');
    Route::get('locations/create', 'LocationCreate')->name('locations-create');
});

Route::prefix('inventory')->name('inventory-')->group(function () {
    Route::post('products/store', [ProductManagementController::class, 'store'])->name('products-store');
    Route::post('categories/store', [CategoryManagementController::class, 'store'])->name('categories-store');
    Route::post('brands/store', [BrandManagementController::class, 'store'])->name('brands-store');
    Route::post('locations/store', [LocationManagementController::class, 'store'])->name('locations-store');
});

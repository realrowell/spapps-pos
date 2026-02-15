<?php

use App\Http\Controllers\Admin\InventoryPageController;
use App\Http\Controllers\Inventory\CategoryManagementController;
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

Route::prefix('inventory')->middleware('auth')->controller(InventoryPageController::class)->name('inventory-')->group(function(){
        Route::get('products','ProductsPage')->name('products');
        Route::get('products/create','ProductCreatePage')->name('products-create');
        Route::get('categories','CategoriesPage')->name('categories');
        Route::get('categories/create','CategoryCreate')->name('categories-create');
});

Route::prefix('inventory')->name('inventory-')->group(function(){
        Route::post('categories/store',[CategoryManagementController::class, 'store'])->name('categories-store');
});

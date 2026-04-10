<?php

use App\Http\Controllers\Admin\InventoryPageController;
use App\Http\Controllers\Admin\PrStockPageController;
use App\Http\Controllers\Inventory\BrandManagementController;
use App\Http\Controllers\Inventory\CategoryManagementController;
use App\Http\Controllers\Inventory\LocationManagementController;
use App\Http\Controllers\Inventory\ProductManagementController;
use App\Http\Controllers\Sale\ModeOfPaymentsManagementController;
use App\Http\Controllers\Admin\SalePageController;
use App\Http\Controllers\Sale\PaymentProviderManagementController;
use App\Http\Controllers\Sale\PointOfSaleManagementController;
use App\Http\Controllers\Stock\PrStockManagementController;
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
    Route::get('products/details/{productId}', 'ProductDetailsPage')->name('products-details');
    Route::get('categories', 'CategoriesPage')->name('categories');
    Route::get('categories/create', 'CategoryCreate')->name('categories-create');
    Route::get('brands', 'BrandsPage')->name('brands');
    Route::get('brands/create', 'BrandCreate')->name('brands-create');
    Route::get('locations', 'LocationsPage')->name('locations');
    Route::get('locations/create', 'LocationCreate')->name('locations-create');
});

Route::prefix('inventory')->name('inventory-')->group(function () {
    Route::post('products/store', [ProductManagementController::class, 'store'])->name('products-store');
    Route::post('products/product-price/store', [ProductManagementController::class, 'addProductPrice'])->name('product-price-store');
    Route::post('categories/store', [CategoryManagementController::class, 'store'])->name('categories-store');
    Route::post('brands/store', [BrandManagementController::class, 'store'])->name('brands-store');
    Route::post('locations/store', [LocationManagementController::class, 'store'])->name('locations-store');
});


Route::prefix('sale')->middleware('auth')->controller(SalePageController::class)->name('sale-')->group(function () {
    Route::get('sales', 'SalesPage')->name('sales');
    Route::get('point-of-sale', 'PointOfSale')->name('pos');
    Route::get('mode-of-payments', 'ModeOfPaymentsPage')->name('mops');
    Route::get('mode-of-payments/create', 'MOPCreate')->name('mops-create');
    Route::get('payment-providers', 'PaymentProvidersPage')->name('payment-providers');
    Route::get('payment-providers/create', 'PaymentProvidersCreate')->name('payment-providers-create');
});

Route::prefix('sale')->name('sale-')->group(function () {
    Route::post('mode-of-payments/store', [ModeOfPaymentsManagementController::class, 'store'])->name('mode-of-payments-store');
    Route::post('payment-providers/store', [PaymentProviderManagementController::class, 'store'])->name('payment-providers-store');
    Route::post('point-of-sale/create-sale-order', [PointOfSaleManagementController::class, 'create'])->name('point-of-sale-create');
    Route::get('point-of-sale/payment/{saleOrder}', [PointOfSaleManagementController::class, 'showPayment'])->name('point-of-sale-payment-show');
    Route::post('point-of-sale/complete-payment', [PointOfSaleManagementController::class, 'createPayment'])->name('point-of-sale-create-payment');
    Route::post('point-of-sale/void-sale/{saleOrderId}', [PointOfSaleManagementController::class, 'voidSaleOrder'])->name('point-of-sale-void-sale');
});


Route::prefix('stocks')->middleware('auth')->controller(PrStockPageController::class)->name('stocks-')->group(function () {
    Route::get('pr-stocks', 'PrStocksPage')->name('pr-stock-page');
    Route::get('pr-stocks/input', 'PrStockInputPage')->name('pr-stock-input-page');
});

Route::prefix('stocks')->name('stocks-')->group(function () {
    Route::post('pr-stocks/store', [PrStockManagementController::class, 'store'])->name('pr-stock-store');
});

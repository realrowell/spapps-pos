<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('inventory', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('inventory');
Route::get('inventory/products', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('products');
Route::get('inventory/categories', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('categories');

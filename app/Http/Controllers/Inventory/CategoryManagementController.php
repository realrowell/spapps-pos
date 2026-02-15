<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreCategoryRequest as InventoryStoreCategoryRequest;
use App\Services\Inventory\CategoryService;
// use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryManagementController extends Controller
{
    public function store(InventoryStoreCategoryRequest $request, CategoryService $service){
        $service->create($request->validated());

        return Inertia::render('inventories/Categories')->with('success', 'Category created successfully.');
    }
}

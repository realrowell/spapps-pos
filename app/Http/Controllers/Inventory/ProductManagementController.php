<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreProductRequest as InventoryStoreProductRequest;
use App\Services\Inventory\ProductService;
use Inertia\Inertia;

class ProductManagementController extends Controller
{
    public function store(InventoryStoreProductRequest $request, ProductService $service){
        $service->create($request->validated());

        $data = [
            'products' => $service->getAll()
        ];
        return Inertia::render('inventories/Products', $data)->with('success', 'Location created successfully.');
    }
}

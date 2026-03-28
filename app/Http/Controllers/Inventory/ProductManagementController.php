<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreProductPricingRequest;
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
    public function addProductPrice(StoreProductPricingRequest $request, ProductService $service){
        $new_pr_price = $service->createPricing($request->validated());

        if($new_pr_price == false){
            return redirect()->back()->with('error','Price type already on record.');
        }

        $data = [
            'products' => $service->getAll()
        ];
        return redirect()->back()->with('success', 'Price type created successfully.');
    }
}

<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreBrandRequest as InventoryStoreBrandRequest;
use App\Services\Inventory\BrandService;
// use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandManagementController extends Controller
{
    public function store(InventoryStoreBrandRequest $request, BrandService $service){
        $service->create($request->validated());

        $data = [
            'brands' => $service->getAll()
        ];
        return Inertia::render('inventories/Brands', $data)->with('success', 'Category created successfully.');
    }
}

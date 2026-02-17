<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreProductRequest as InventoryStoreProductRequest;
use App\Models\Product;
// use Illuminate\Http\Request;

class ProductManagementController extends Controller
{
    public function create(InventoryStoreProductRequest $request){
        $product = Product::create($request->validated());

        return response()->json($product, 201);
    }
}

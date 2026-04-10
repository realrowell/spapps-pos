<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stock\StorePrStockInputRequest;
use App\Services\Stock\PrStockService;
use Inertia\Inertia;

class PrStockManagementController extends Controller
{
    public function store(StorePrStockInputRequest $request, PrStockService $service){
        $service->create($request->validated());

        $data = [
            'pr_inventory' => $service->getAll()
        ];
        return Inertia::render('stocks/ProductStocks', $data)->with('success', 'Stock Inputed Successfully.');
    }
}

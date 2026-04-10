<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Inventory\LocationService;
use App\Services\Inventory\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrStockPageController extends Controller
{
    public function __construct(
        private ProductService $prService,
        private LocationService $locService,
    ){}

    public function PrStocksPage(){
        return Inertia::render('stocks/ProductStocks');
    }

    public function PrStockInputPage(){
        $data = [
            'products' => $this->prService->getAllActive(),
            'locations' => $this->locService->getAllActive(),
        ];
        return Inertia::render('stocks/PrStockInput', $data);
    }
}

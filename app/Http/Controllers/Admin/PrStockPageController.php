<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrStockPageController extends Controller
{
    //

    public function PrStocksPage(){
        return Inertia::render('stocks/ProductStocks');
    }
}

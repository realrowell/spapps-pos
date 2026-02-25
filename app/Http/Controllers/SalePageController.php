<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SalePageController extends Controller
{
    public function SalesPage(){
        return Inertia::render('sales/Sales');
    }

    public function PointOfSale(){
        return Inertia::render('sales/POS');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryPageController extends Controller
{
    public function ProductsPage(){

        return Inertia::render('inventories/Products');
    }

    public function ProductCreatePage(){

        return Inertia::render('inventories/ProductCreate');
    }

    public function CategoriesPage(){
        $data = [
            'categories' => PrCategory::where('is_active', true)->get()
        ];
        return Inertia::render('inventories/Categories', $data);
    }

    public function CategoryCreate(){
        return Inertia::render('inventories/CategoryCreate');
    }
}

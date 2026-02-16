<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrBrand;
use App\Models\PrCategory;
use App\Services\Inventory\CategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryPageController extends Controller
{
    public function ProductsPage()
    {

        return Inertia::render('inventories/Products');
    }

    public function ProductCreatePage()
    {

        return Inertia::render('inventories/ProductCreate');
    }

    public function CategoriesPage(CategoryService $service)
    {
        $data = [
            'categories' => $service->getAll(),
        ];
        return Inertia::render('inventories/Categories', $data);
    }

    public function CategoryCreate()
    {
        return Inertia::render('inventories/CategoryCreate');
    }

    public function BrandsPage()
    {
        $data = [
            'brands' => PrBrand::all()
        ];
        return Inertia::render('inventories/Brands', $data);
    }
}

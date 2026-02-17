<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\PrBrand;
use App\Services\Inventory\BrandService;
use App\Services\Inventory\CategoryService;
use App\Services\Inventory\LocationService;
use App\Services\Inventory\ProductService;
use Inertia\Inertia;

class InventoryPageController extends Controller
{
    private $catService;
    private $prService;
    private $brService;
    private $locService;

    public function __construct(CategoryService $catService, ProductService $prService, BrandService $brService, LocationService $locService){
        $this->catService = $catService;
        $this->prService = $prService;
        $this->brService = $brService;
        $this->locService = $locService;
    }


    public function ProductsPage()
    {
        $data = [
            'brands' => $this->prService->getAll()
        ];
        return Inertia::render('inventories/Products',$data);
    }

    public function ProductCreatePage()
    {
        $data = [
            'categories' => $this->catService->getAllActive(),
            'brands' => $this->brService->getAllActive(),
            'uomOptions' => $this->prService->getUom(),
            'statusOptions' => $this->prService->getStatus(),
            'priceTypeOptions' => $this->prService->getPriceType(),
            'locations' => $this->locService->getAllActive(),
        ];
        return Inertia::render('inventories/ProductCreate', $data);
    }

    public function CategoriesPage()
    {
        $data = [
            'categories' => $this->catService->getAll(),
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
    public function BrandCreate()
    {
        return Inertia::render('inventories/BrandCreate');
    }

    public function LocationsPage()
    {
        $data = [
            'locations' => Location::all()
        ];
        return Inertia::render('inventories/Locations', $data);
    }
    public function LocationCreate()
    {
        return Inertia::render('inventories/LocationCreate');
    }
}

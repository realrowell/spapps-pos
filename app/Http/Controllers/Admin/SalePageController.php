<?php

namespace App\Http\Controllers\Admin;

// use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\ModeOfPayment;
use App\Services\Inventory\BrandService;
use App\Services\Inventory\CategoryService;
use App\Services\Inventory\LocationService;
use App\Services\Inventory\ProductService;
use App\Services\Sale\ModeOfPaymentService;
use App\Services\Sale\PaymentProviderService;
use App\Services\Sale\SaleOrderService;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SalePageController extends Controller
{
    private $mopService;
    private $paymentProviderService;
    private $catService;
    private $prService;
    private $brService;
    private $locService;
    private $saleService;

    public function __construct(
        ModeOfPaymentService $mopService,
        PaymentProviderService $paymentProviderService,
        CategoryService $catService,
        ProductService $prService,
        BrandService $brService,
        LocationService $locService,
        SaleOrderService $saleService
    ) {
        $this->mopService = $mopService;
        $this->paymentProviderService = $paymentProviderService;
        $this->catService = $catService;
        $this->prService = $prService;
        $this->brService = $brService;
        $this->locService = $locService;
        $this->saleService = $saleService;
    }

    public function SalesPage(SaleOrderService $service)
    {
        $data=[
            'sales' => $service->getAll(),
        ];
        return Inertia::render('sales/Sales', $data);
    }

    public function PointOfSale()
    {
        $data = [
            'user' => Auth::user(),
            'categories' => $this->catService->getAllActive(),
            'brands' => $this->brService->getAllActive(),
            'products' => $this->prService->getAllActive(),
            'so_number' => IdGenerator::generate(['table' => 'sales', 'field' => 'sale_ref', 'length' => 11, 'prefix' => 'SO' . date('ym') . '-']),
            'locations' => $this->locService->getAllActive(),
            'payment_providers' => $this->paymentProviderService->getAllActive(),
            'sales' => $this->saleService->getAllUnpaid(),
        ];
        return Inertia::render('sales/POS', $data);
    }

    public function ModeOfPaymentsPage()
    {
        $data = [
            'mops' => $this->mopService->getAll(),
        ];
        return Inertia::render('sales/MOPs', $data);
    }
    public function MOPCreate()
    {
        $data = [
            'generatedCode' => IdGenerator::generate(['table' => 'mode_of_payments', 'field' => 'mop_code', 'length' => 6, 'prefix' => str()->random(5)]),
            'typeOptions' => ModeOfPayment::mopTypeOptions(),
        ];
        return Inertia::render('sales/MOPCreate', $data);
    }

    public function PaymentProvidersPage()
    {
        $data = [
            'payment_providers' => $this->paymentProviderService->getAll(),
        ];
        return Inertia::render('sales/PaymentProviders', $data);
    }

    public function PaymentProvidersCreate()
    {
        $data = [
            'generatedCode' => IdGenerator::generate(['table' => 'payment_providers', 'field' => 'provider_code', 'length' => 9, 'prefix' => 'PROV-' . str()->random(3)]),
            'mops' => $this->mopService->getAllActive(),
        ];
        return Inertia::render('sales/PaymentProviderCreate', $data);
    }
}

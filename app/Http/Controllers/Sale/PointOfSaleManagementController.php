<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleOrderRequest;
use App\Services\Sale\SaleOrderService;
use Illuminate\Support\Facades\Auth;
use App\Services\Inventory\BrandService;
use App\Services\Inventory\CategoryService;
use App\Services\Inventory\LocationService;
use App\Services\Inventory\ProductService;
use App\Services\Sale\ModeOfPaymentService;
use App\Services\Sale\PaymentProviderService;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Inertia\Inertia;

class PointOfSaleManagementController extends Controller
{
    private $mopService;
    private $paymentProviderService;
    private $catService;
    private $prService;
    private $brService;
    private $locService;

    public function __construct(
        ModeOfPaymentService $mopService,
        PaymentProviderService $paymentProviderService,
        CategoryService $catService,
        ProductService $prService,
        BrandService $brService,
        LocationService $locService)
    {
        $this->mopService = $mopService;
        $this->paymentProviderService = $paymentProviderService;
        $this->catService = $catService;
        $this->prService = $prService;
        $this->brService = $brService;
        $this->locService = $locService;
    }

    public function store(StoreSaleOrderRequest $request, SaleOrderService $saleOrderService){
        $saleOrder = $saleOrderService->create($request->validated());
        // $paymentMethod = $this->paymentProviderService->findByCode($request->validated()['payment_method']);
        $data = [
            'user' => Auth::user(),
            'sale_order' => $saleOrderService->getById($saleOrder->id),
            // 'payment_method' => $paymentMethod,
            'so_number' => $saleOrder->sale_ref,
            'payment_providers' => $this->paymentProviderService->getAllActive(),
        ];
        return Inertia::render('sales/POSPaymentPage', $data)->with('success', 'Provider created successfully.');
    }

    public function payment(){

    }
}

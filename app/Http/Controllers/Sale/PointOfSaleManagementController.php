<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreSaleOrderRequest;
use App\Http\Requests\Sale\StoreSalePaymentRequest;
use App\Services\Sale\SaleOrderService;
use Illuminate\Support\Facades\Auth;
use App\Services\Inventory\BrandService;
use App\Services\Inventory\CategoryService;
use App\Services\Inventory\LocationService;
use App\Services\Inventory\ProductService;
use App\Services\Sale\ModeOfPaymentService;
use App\Services\Sale\PaymentProviderService;
use App\Services\Sale\SalePaymentService;
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

    public function create(StoreSaleOrderRequest $request, SaleOrderService $saleOrderService){
        $saleOrder = $saleOrderService->create($request->validated());

        // Redirect to GET route instead of rendering directly
        return redirect()->route('sale-point-of-sale-payment-show', $saleOrder->sale_ref)->with('success', 'Sale Order created successfully.');
    }

    public function showPayment(SaleOrderService $saleOrderService, $saleOrderId){
        $salePayment = $saleOrderService->getByRef($saleOrderId);
        $saleOrder = $saleOrderService->getByRef($saleOrderId);
        // dd($salePayment);
        // if($salePayment != null){
        //     if($salePayment->status === 'paid'){
        //         return redirect()->route('sale-pos')->with('error', 'This sale order has already been paid.');
        //     }
        // } else {
        //     return redirect()->route('sale-pos')->with('error', 'Sale order not found.');
        // }

        if($saleOrder != null && $saleOrder->status == 'completed'){
            session()->flash('error', 'This sale order has already been paid.');
            return redirect()->route('sale-pos');
        }

        $data = [
            'user' => Auth::user(),
            'sale_order' => $saleOrderService->getByRef($saleOrderId),
            'so_number' => $saleOrderId,
            'payment_providers' => $this->paymentProviderService->getAllActive(),
            'sale_payments' => $saleOrder->sale_payments ?? null,
        ];
        return Inertia::render('sales/POSPaymentPage', $data);
    }

    public function createPayment(StoreSalePaymentRequest $request, SalePaymentService $salePaymentService){
        $salePayment = $salePaymentService->create($request->validated());
        $data = [
            'salePayment' => $salePayment
        ];
        return redirect()->route('sale-pos')->with('success', 'Payment Successful.');
    }

    public function voidSaleOrder($saleOrderId, SaleOrderService $saleOrderService){
        $saleOrder = $saleOrderService->getByRef($saleOrderId);
        if (!$saleOrder) {
            return redirect()->route('sale-pos')->with('error', 'Sale Order not found.');
        }
        $voidedSaleOrder = $saleOrderService->updateStatus($saleOrder, 'void');

        return redirect()->route('sale-pos')->with('success', $voidedSaleOrder);
    }
}

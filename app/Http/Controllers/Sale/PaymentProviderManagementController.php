<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StorePaymentProviderRequest as SaleStorePaymentProviderRequest;
use App\Services\Sale\PaymentProviderService;
use Inertia\Inertia;

class PaymentProviderManagementController extends Controller
{
    public function store(SaleStorePaymentProviderRequest $request, PaymentProviderService $service){
        $service->create($request->validated());

        $data = [
            'payment_providers' => $service->getAll()
        ];
        return Inertia::render('sales/PaymentProviders', $data)->with('success', 'Provider created successfully.');
    }
}

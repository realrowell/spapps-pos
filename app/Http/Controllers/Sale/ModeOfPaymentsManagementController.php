<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\StoreModeOfPaymentRequest as SaleStoreModeOfPaymentRequest;
use App\Services\Sale\ModeOfPaymentService;
use Inertia\Inertia;

class ModeOfPaymentsManagementController extends Controller
{
    public function store(SaleStoreModeOfPaymentRequest $request, ModeOfPaymentService $service){
        $service->create($request->validated());

        $data = [
            'mops' => $service->getAll()
        ];
        return Inertia::render('sales/MOPs', $data)->with('success', 'Location created successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

// use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\ModeOfPayment;
use App\Services\Sale\ModeOfPaymentService;
use App\Services\Sale\PaymentProviderService;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Inertia\Inertia;

class SalePageController extends Controller
{
    private $mopService;
    private $paymentProviderService;
    public function __construct(ModeOfPaymentService $mopService, PaymentProviderService $paymentProviderService)
    {
        $this->mopService = $mopService;
        $this->paymentProviderService = $paymentProviderService;
    }

    public function SalesPage(){
        return Inertia::render('sales/Sales');
    }

    public function PointOfSale(){
        return Inertia::render('sales/POS');
    }

    public function ModeOfPaymentsPage(){
        $data = [
            'mops' => $this->mopService->getAll(),
        ];
        return Inertia::render('sales/MOPs', $data);
    }
    public function MOPCreate(){
        $data = [
            'generatedCode' => IdGenerator::generate(['table' => 'mode_of_payments', 'field' => 'mop_code', 'length' => 6, 'prefix' => str()->random(5)]),
            'typeOptions' => ModeOfPayment::mopTypeOptions(),
        ];
        return Inertia::render('sales/MOPCreate', $data);
    }

    public function PaymentProvidersPage(){
        $data = [
            'payment_providers' => $this->paymentProviderService->getAll(),
        ];
        return Inertia::render('sales/PaymentProviders', $data);
    }

    public function PaymentProvidersCreate(){
        $data = [
            'generatedCode' => IdGenerator::generate(['table' => 'payment_providers', 'field' => 'provider_code', 'length' => 9, 'prefix' => 'PROV-'.str()->random(3)]),
            'mops' => $this->mopService->getAllActive(),
        ];
        return Inertia::render('sales/PaymentProviderCreate', $data);
    }
}

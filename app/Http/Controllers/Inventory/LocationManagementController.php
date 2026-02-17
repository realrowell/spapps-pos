<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreLocationRequest as InventoryStoreLocationRequest;
use App\Services\Inventory\LocationService;
use Inertia\Inertia;

class LocationManagementController extends Controller
{
    public function store(InventoryStoreLocationRequest $request, LocationService $service){
        $service->create($request->validated());

        $data = [
            'locations' => $service->getAll()
        ];
        return Inertia::render('inventories/Locations', $data)->with('success', 'Location created successfully.');
    }
}

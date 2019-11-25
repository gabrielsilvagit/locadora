<?php

namespace App\Http\Controllers;

use App\Rental;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\CheckOutRequest;
use App\Services\CheckOutRentalService;
use App\Services\CheckOutCleaningService;
use App\Services\CheckOutMaintenanceService;

class CheckOutController extends Controller
{
    protected $checkOutRentalService;
    protected $checkOutMaintenaceService;
    protected $checkOutCleaningService;

    use ApiResponser;

    public function __construct(
        CheckOutRentalService $checkOutRentalService,
        CheckOutMaintenanceService $checkOutMaintenanceService,
        CheckOutCleaningService $checkOutCleaningService
    ) {
        $this->checkOutRentalService = $checkOutRentalService;
        $this->checkOutMaintenanceService = $checkOutMaintenanceService;
        $this->checkOutCleaningService = $checkOutCleaningService;
    }

    public function checkout(CheckOutRequest $request)
    {
        $rental_id = $request->rental_id;
        $rental= Rental::find($rental_id);
        switch ($rental->type) {
            case 'rent':
                $rental = $this->checkOutRentalService->checkOutRental($request);
                if ($rental == false) {
                    return $this->errorResponse('error', 422);
                }
                return $this->successResponse($rental, 201);
            break;

            case 'maintenance':
                $rental = $this->checkOutMaintenanceService->checkOutMaintenance($request);
                if ($rental == false) {
                    return $this->errorResponse('error', 422);
                }
                return $this->successResponse($rental, 201);
            break;

            case 'cleaning':
                $rental = $this->checkOutCleaningService->checkOutCleaning($request);
                if ($rental == false) {
                    return $this->errorResponse('error', 422);
                }
                return $this->successResponse($rental, 201);
            break;
        }
    }
}

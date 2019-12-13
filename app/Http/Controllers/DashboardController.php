<?php

namespace App\Http\Controllers;

use App\Rental;
use App\Vehicle;
use Carbon\Carbon;
use App\Traits\ApiResponser;

class DashboardController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $todayRentals = Rental::where('start_date', Carbon::today())->where('vehicle_id', null)->get();
        $nextsRentals = Rental::where('start_date', '>', Carbon::today())->where('vehicle_id', null)->take(10)->get();
        $nextsDropoffs = Rental::where('end_date', '>=', Carbon::today())->where('type', '!=', 'maintenance')
        ->where('vehicle_id', '!=', null)->take(10)->get();
        $maintenanceVehicles = Rental::where('type', 'maintenance')
            ->where('end_date', '>', Carbon::today())->get();
        $cleaningVehicles = Rental::where('type', 'cleaning')
            ->where('end_date', '>=', Carbon::today())->get();
        $vehicles_ids = Rental::where('end_date', '<', Carbon::today())
            ->orWhere('start_date', '>', Carbon::today())
            ->select('vehicle_id')
            ->orderBy('category', 'asc')
            ->get()
            ->toArray();
        $vehiclesPerCategory = null;
        foreach ($vehicles_ids as $vehicle_id) {
            $id = $vehicle_id['vehicle_id'];
            if ($id != null) {
                $vehiclesPerCategory = Vehicle::find($id)->get();
            }
        }

        return $this->successResponse([
            $todayRentals,
            $nextsRentals,
            $nextsDropoffs,
            $maintenanceVehicles,
            $cleaningVehicles,
            $vehiclesPerCategory
        ], 200);
    }
}

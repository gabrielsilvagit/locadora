<?php

namespace App\Http\Controllers;

use App\Rental;
use App\Vehicle;
use Carbon\Carbon;
use App\Maintenance;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $todayRentals = Rental::where('start_date', Carbon::today())->get();
        $nextsRentals = Rental::where('start_date', '>', Carbon::today())->take(10)->get();
        $nextsDropoffs = Rental::where('end_date', '>=', Carbon::today())->take(10)->get();
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

        foreach ($vehicles_ids as $vehicle_id) {
            $id = $vehicle_id['vehicle_id'];
            $vehiclesPerCategory = Vehicle::find($id)->get()->toArray();
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

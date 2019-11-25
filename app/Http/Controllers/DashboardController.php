<?php

namespace App\Http\Controllers;

use App\Maintenance;
use App\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todayRentals = Rental::where('start_date', Carbon::today())->get();
        dd($todayRentals);
        $nextsRentals = Rental::where('start_date', '>', Carbon::today())->take(10)->get();
        $nextsDropoffs = Rental::where('end_date', Carbon::today())->take(10)->get();
        $plates = Rental::where('end_date', '<', Carbon::today())
        ->where('start_date', '>', Carbon::today())->select('plate')->get();
        foreach ($plates as $plate) {
            $vehiclesPerCategory = Vehicle::where('plate', $plate)->orderBy('category')->get();
        }
        $maintenanceVehicles = Rental::where('type', 'maintenance')
        ->where('end_date', '>', Carbon::today());
        $cleaningVehicles = Rental::where('type', 'cleaning')
        ->where('end_date', '>=', Carbon::today());
    }
}

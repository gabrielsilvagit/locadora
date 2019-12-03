<?php

namespace App\Services;

use App\Rental;
use App\Vehicle;
use Carbon\Carbon;

class CheckOutMaintenanceService
{
    public function checkOutMaintenance($request)
    {
        $rental_id = $request->rental_id;
        $rental=Rental::find($rental_id);
        $vehicle = Vehicle::where('plate', $request->plate)->first();
        if ($rental->vehicle->plate == $request->plate) {
            $rental['vehicle_id'] = $vehicle->id;
            $rental['start_date'] = Carbon::today();
            $rental->save();
            return $rental;
        }
    }
}

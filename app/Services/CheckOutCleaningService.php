<?php

namespace App\Services;

use App\Rental;
use Carbon\Carbon;

class CheckOutCleaningService
{
    public function checkOutCleaning($request)
    {
        $rental_id = $request->rental_id;
        $rental=Rental::find($rental_id);
        $vehicle = Vehicle::where('plate', $request->plate)->get();
        if ($rental->vehicle->plate == $request->plate) {
            $rental['vehicle_id'] = $vehicle->id;
            $rental['start_date'] = Carbon::today();
            $rental->save();
            return $rental;
        }
    }
}

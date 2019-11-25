<?php

namespace App\Services;

use App\Rental;
use Carbon\Carbon;

class CheckOutMaintenanceService
{
    public function checkOutMaintenance($request)
    {
        $rental_id = $request->rental_id;
        $rental=Rental::find($rental_id);
        if ($rental->plate == $request->plate) {
            $rental['plate'] = $request->plate;
            $rental['start_date'] = Carbon::today();
            $rental->save();
            return $rental;
        }
    }
}

<?php

namespace App\Services;

use App\Rental;
use Carbon\Carbon;

class CheckOutRentalService
{
    public function checkOutRental($request)
    {
        $rental_id = $request->rental_id;
        $rental=Rental::find($rental_id);
        if ($rental->category_id == $request->category_id) {
            $rental['plate'] = $request->plate;
            $rental['current_km'] = $request->current_km;
            $rental['fuel_level'] = $request->fuel_level;
            $rental['start_date'] = Carbon::today();
            $rental->save();
            return $rental;
        }

        return false;
    }
}

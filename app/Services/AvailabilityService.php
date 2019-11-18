<?php

namespace App\Services;

use App\Rental;
use App\Vehicle;
use Carbon\Carbon;

class AvailabilityService {
    public function available($newRental)
    {
        $start = Carbon::parse($newRental['start_date']);
        $end = Carbon::parse($newRental['end_date']);
        $vehicle = Vehicle::where('id','=',$newRental['vehicle_id'])->first();

        $rentals = Rental::where('vehicle_id','=',$vehicle->id)->get();

        foreach($rentals as $rental){
            if(!$rental->start>$end || $rental->end<$start){
                return false;
            }
        }
        return true;
    }
}

<?php

namespace App\Services;

use App\Rental;
use App\Vehicle;
use App\Category;
use Carbon\Carbon;

class AvailabilityService {

    public function available($category_id, $start, $end)
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        $unavailable = Rental::where('category_id','=',$category_id)
            // ->where(function($q1) use($start, $end) {
            //     return $q1->where($start, "<", "start_date")->where($end, ">", "end_date");
            // })
            // ->orWhere(function($q2)  use($start, $end) {
            //     return $q2->where($start, "<", "start_date")->where($end, "<", "end_date")->where($end,'>',"start_date");
            // })
            // ->orWhere(function($q3)  use($start, $end) {
            //     return $q3->where($start, ">", "start_date")->where($end, ">", "end_date")->where($start,'<',"end_date");
            // })
            // ->where(function($q4)  use($start, $end) {
            //     return $q4->where($start, ">", "start_date")->where($end, "<", "end_date");
            // })
            ->where(function($q4)  use($start, $end) {
                return $q4->where("start_date", Carbon::parse($start)->format("Y-m-d"))->where("end_date", Carbon::parse($end)->format("Y-m-d"));
            })
            ->count();
        $total = Vehicle::where('category_id','=',$category_id)->count();

        dd($unavailable,$total, Carbon::parse($start)->format("Y-m-d"), $end);

        if ($total >= $unavailable) {
            return true;
        }
        return false;
    }
}

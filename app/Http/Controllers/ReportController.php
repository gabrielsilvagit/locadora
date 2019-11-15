<?php

namespace App\Http\Controllers;

use App\Fuel;
use App\User;
use App\Rental;
use App\DropOff;
use App\Vehicle;
use App\Category;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function show(DropOff $dropoff)
    {
        $report=[];
        $report['daily_price'] = null;
        $report['total'] = null;
        $report['fuel_price'] = null;
        $report['km_price'] = null;
        
        try{
            $rental= Rental::where('id', '=', $dropoff->rental_id)->first();
            $user = User::where('id', '=', $rental->user_id)->first();
            $vehicle = Vehicle::where('id', '=', $rental->vehicle_id)->first();
            $category = Category::where('id', '=', $vehicle->category_id)->first();
            $fuel = Fuel::where('id', '=', $vehicle->fuel_id)->first();

            $start_time = \Carbon\Carbon::parse($rental->start_date);
            $finish_time = \Carbon\Carbon::parse($dropoff->created_at);
            $daily = $start_time->diffInDays($finish_time, false);

            $dob = \Carbon\Carbon::parse($user->dob);
            $actual = \Carbon\Carbon::parse(now());
            $old = $dob->diffInYears($actual, false);

            if(!$rental->limited){
                $report['daily_price']= ($category->free_daily_rate * $daily);
                $report['km_price']= null;
            } else {
                $report['daily_price']= $rental->daily_rate * $daily;
                $report['km_price']= (($dropoff->current_km - $rental->current_km) * $category->extra_km_price) ;
            }
            if($rental->fuel_level>$dropoff->fuel_level) {
                $fuel_level=$rental->fuel_level-$dropoff->fuel_level;
                $report['fuel_price']= $fuel_level * $fuel->price;
            } else {
                $report['fuel_price']= null;
            }

            if($old<25){
                $report['daily_price']=($report['daily_price']*1.25);
            }

            $report['total'] = $report['daily_price']+$report['km_price']+$report['fuel_price'];
            dd($report);



            return $this->successResponse($report, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
}

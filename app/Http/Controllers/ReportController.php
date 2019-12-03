<?php

namespace App\Http\Controllers;

use App\Fuel;
use App\User;
use Exception;
use App\Rental;
use App\DropOff;
use App\Vehicle;
use App\Category;
use App\Setting;
use Carbon\Carbon;
use App\Traits\ApiResponser;
use phpDocumentor\Reflection\Types\Integer;

class ReportController extends Controller
{
    use ApiResponser;

    public function show(DropOff $dropoff)
    {
        $report=[];
        $report['daily_price'] = null;
        $report['total'] = null;
        $report['fuel_price'] = null;
        $report['km_price'] = null;
        $report['damage_notes'] = null;

        try {
            $rental= Rental::where('id', '=', $dropoff->rental_id)->first();
            $settings= Setting::find(1);
            $user = User::where('id', '=', $rental->user_id)->first();
            $category = Category::where('id', '=', $rental->category_id)->first();
            $vehicle = Vehicle::where('category_id', '=', $category->id)->first();
            $fuel = Fuel::where('id', '=', $vehicle->fuel_id)->first();
            $start_time = Carbon::parse($rental->start_date);
            $finish_time = Carbon::parse($rental->end_date);
            $daily = $start_time->diffInDays($finish_time, false);

            if ($daily == 0) {
                $daily = 1;
            }

            if ($dropoff->damage == false) {
                $report['damage_notes'] = $dropoff->damage_notes;
            }
            if (!!$rental->free_km) {
                $report['daily_price']= ($category->free_daily_rate * $daily);
                $report['km_price']= null;
            } else {
                $report['daily_price']= $rental->daily_rate * $daily;
                if (($dropoff->current_km - $rental->current_km) > $settings->base_km) {
                    $report['km_price']= (($dropoff->current_km - $rental->current_km) * $category->extra_km_price);
                }
            }
            if ($rental->fuel_level>$dropoff->fuel_level) {
                $fuel_level=$rental->fuel_level-$dropoff->fuel_level;
                $report['fuel_price']= $fuel_level * $fuel->price;
            } else {
                $report['fuel_price']= null;
            }

            if ($user->age_aditional) {
                $report['daily_price']=($report['daily_price']*$rental->age_aditional);
            }
            $report['total'] = $report['daily_price']+$report['km_price']+$report['fuel_price'];

            return $this->successResponse($report, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
}

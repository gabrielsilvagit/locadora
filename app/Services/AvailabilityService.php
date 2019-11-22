<?php

namespace App\Services;

use App\Rental;
use App\Vehicle;
use Carbon\Carbon;

class AvailabilityService
{
    public function checkAvaliability($category_id, $startDate, $endDate)
    {
        // after every rental the vehicle must be cleaned
        // to do so, we make sure no vehicle is going to be rented 1 day after returning
        $startDate = Carbon::parse($startDate)->subDay();

        // get all rentals that overlap the renting dates
        $rentals = Rental::where('category_id', $category_id)
            ->where(function ($query) use ($startDate, $endDate) {
                return $query->where(function ($q1) use ($startDate, $endDate) {
                    return $q1->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                })
                ->orWhere(function ($q2) use ($startDate, $endDate) {
                    return $q2->where('start_date', '>', $startDate)
                        ->where('end_date', '<', $endDate);
                })
                ->orWhere(function ($q3) use ($startDate, $endDate) {
                    return $q3->where('start_date', '>', $startDate)
                        ->where('start_date', '<=', $endDate)
                        ->where('end_date', '>', $endDate);
                })
                ->orWhere(function ($q4) use ($startDate, $endDate) {
                    return $q4->where('start_date', '<', $startDate)
                        ->where('end_date', '>=', $startDate)
                        ->where('end_date', '<', $endDate);
                })
                ->orWhere(function ($q5) use ($startDate, $endDate) {
                    return $q5->where('start_date', '=', $startDate)
                        ->where('end_date', '<>', $endDate);
                })
                ->orWhere(function ($q6) use ($startDate, $endDate) {
                    return $q6->where('start_date', '<>', $startDate)
                        ->where('end_date', '=', $endDate);
                });
            })
            ->count();

        // get all available vehicles for the given category
        $vehicles = Vehicle::where('category_id', $category_id)->count();

        return $vehicles > $rentals;
    }
}

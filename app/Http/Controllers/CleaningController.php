<?php

namespace App\Http\Controllers;

use App\Rental;
use App\Vehicle;
use Carbon\Carbon;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CleaningRequest;

class CleaningController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $cleanings = Rental::where('type', 'cleaning')->get();

        return $this->successResponse($cleanings, 200);
    }

    public function store(CleaningRequest $request)
    {
        $end_date = Carbon::parse($request->start_date)->addDay();
        $vehicle = Vehicle::where('plate', $request->plate)->first();
        $data = [
            'user_id' => Auth::id(),
            'type' => 'cleaning',
            'start_date' => $request->start_date,
            'end_date' => $end_date,
            'category_id' => $vehicle->category_id,
            'notes' => $request->notes,
            'vehicle_id' => $vehicle->id,
        ];
        $cleaning = Rental::create($data);

        return $this->successResponse($cleaning, 201);
    }

    public function show(Rental $cleaning)
    {
        return $this->successResponse($cleaning, 200);
    }

    public function update(CleaningRequest $request, Rental $cleaning)
    {
        $end_date = Carbon::parse($request->start_date)->addDay();
        $vehicle = Vehicle::where('plate', $request->plate)->first();
        $data = [
            'user_id' => Auth::id(),
            'type' => 'cleaning',
            'start_date' => $request->start_date,
            'end_date' => $end_date,
            'category_id' => $vehicle->category_id,
            'notes' => $request->notes,
            'vehicle_id' => $vehicle->id,
        ];
        $cleaning->update($data);

        return $this->successResponse($cleaning, 201);
    }

    public function destroy(Rental $cleaning)
    {
        $cleaning->delete();

        return $this->successResponse($cleaning, 200);
    }
}

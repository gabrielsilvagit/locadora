<?php

namespace App\Http\Controllers;

use App\Rental;
use App\Vehicle;
use Carbon\Carbon;
use App\Maintenance;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MaintenanceRequest;

class MaintenanceController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $maintenances = Rental::where('type', 'maintenance')->get();
        return $this->successResponse($maintenances, 200);
    }

    public function store(MaintenanceRequest $request)
    {
        $end_date = Carbon::parse($request->start_date)->addYears(5000);
        $vehicle = Vehicle::where('plate', $request->plate)->select('id')->first();
        $data = [
            'user_id' => Auth::id(),
            'type' => 'maintenance',
            'start_date' => $request->start_date,
            'end_date' => $end_date,
            'category_id' => $request->category_id,
            'notes' => $request->notes,
            'vehicle_id' => $vehicle->id,
        ];
        $maintenance = Rental::create($data);
        return $this->successResponse($maintenance, 201);
    }

    public function show(Rental $maintenance)
    {
        return $this->successResponse($maintenance, 200);
    }

    public function update(MaintenanceRequest $request, Rental $maintenance)
    {
        $end_date = Carbon::parse($request->start_date)->addYears(5000);
        $vehicle = Vehicle::where('plate', $request->plate)->first();
        $data = [
            'user_id' => Auth::id(),
            'type' => 'maintenance',
            'start_date' => $request->start_date,
            'end_date' => $end_date,
            'category_id' => $request->category_id,
            'notes' => $request->notes,
            'vehicle_id' => $vehicle->id,
        ];
        $maintenance->update($data);
        return $this->successResponse($maintenance, 201);
    }

    public function destroy(Rental $maintenance)
    {
        $maintenance->delete();
        return $this->successResponse($maintenance, 200);
    }
}

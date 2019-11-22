<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\Traits\ApiResponser;
use App\Http\Requests\VehicleRequest;

class VehicleController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $vehicles = Vehicle::all();

        return $this->successResponse($vehicles, 200);
    }

    public function store(VehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->all());

        return $this->successResponse($vehicle, 201);
    }

    public function show(Vehicle $vehicle)
    {
        return $this->successResponse($vehicle);
    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->all());

        return $this->successResponse($vehicle, 201);
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return $this->successResponse($vehicle, 200);
    }
}

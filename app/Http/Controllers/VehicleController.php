<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Exception;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleRequest;

class VehicleController extends Controller
{
    use ApiResponser;

    public function index()
    {
        try {
            $vehicles = Vehicle::all();
            return $this->successResponse($vehicles, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function store(VehicleRequest $request)
    {
        try {
            $vehicle = Vehicle::create($request->all());
            return $this->successResponse($vehicle, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        try {
            $vehicle->update($request->all());
            return $this->successResponse($vehicle, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function destroy(Vehicle $vehicle)
    {
        try {
            $vehicle->delete();
            return $this->successResponse($vehicle, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
}

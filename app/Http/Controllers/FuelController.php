<?php

namespace App\Http\Controllers;

use App\Fuel;
use Exception;
use App\Traits\ApiResponser;
use App\Http\Requests\FuelRequest;

class FuelController extends Controller
{
    use ApiResponser;

    public function index()
    {
        try {
            $fuels = Fuel::all();

            return $this->successResponse($fuels, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function store(FuelRequest $request)
    {
        try {
            $fuel = Fuel::create($request->all());

            return $this->successResponse($fuel, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function show(Fuel $fuel)
    {
        return $this->successResponse($fuel);
    }

    public function update(FuelRequest $request, Fuel $fuel)
    {
        try {
            $fuel->update($request->all());

            return $this->successResponse($fuel, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function destroy(Fuel $fuel)
    {
        try {
            $fuel->delete();

            return $this->successResponse($fuel, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
}

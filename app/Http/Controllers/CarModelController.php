<?php

namespace App\Http\Controllers;

use Exception;
use App\CarModel;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\CarModelRequest;

class CarModelController extends Controller
{
    use ApiResponser;

    public function index()
    {
        try {
            $carmodels = CarModel::all();
            return $this->successResponse($carmodels, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function store(CarModelRequest $request)
    {
        try {
            $carmodel = CarModel::create($request->all());
            return $this->successResponse($carmodel, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
    public function update(CarModelRequest $request, CarModel $carmodel)
    {
        try {
            $carmodel->update($request->all());
            return $this->successResponse($carmodel, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function destroy(CarModel $carmodel)
    {
        try {
            $carmodel->delete();
            return $this->successResponse($carmodel, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
}

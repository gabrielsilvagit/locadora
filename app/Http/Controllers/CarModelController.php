<?php

namespace App\Http\Controllers;

use App\CarModel;
use App\Traits\ApiResponser;
use App\Http\Requests\CarModelRequest;

class CarModelController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $carmodels = CarModel::all();

        return $this->successResponse($carmodels, 200);
    }

    public function store(CarModelRequest $request)
    {
        $carmodel = CarModel::create($request->all());

        return $this->successResponse($carmodel, 201);
    }

    public function show(CarModel $carmodel)
    {
        return $this->successResponse($carmodel);
    }

    public function update(CarModelRequest $request, CarModel $carmodel)
    {
        $carmodel->update($request->all());

        return $this->successResponse($carmodel, 201);
    }

    public function destroy(CarModel $carmodel)
    {
        $carmodel->delete();

        return $this->successResponse($carmodel, 200);
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use App\DropOff;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\DropOffRequest;

class DropOffController extends Controller
{
    use ApiResponser;

    public function index()
    {
        try {
            $dropoffs = DropOff::all();
            return $this->successResponse($dropoffs, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function store(DropOffRequest $request)
    {
        try {
            $dropoff = DropOff::create($request->all());
            return $this->successResponse($dropoff, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
    public function update(DropOffRequest $request, DropOff $dropoff)
    {
        try {
            $dropoff->update($request->all());
            return $this->successResponse($dropoff, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function destroy(DropOff $dropoff)
    {
        try {
            $dropoff->delete();
            return $this->successResponse($dropoff, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use App\Rental;
use App\DropOff;
use App\Vehicle;
use Carbon\Carbon;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\DropOffRequest;

class DropOffController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $dropoffs = DropOff::all();
        return $this->successResponse($dropoffs, 200);
    }

    public function store(DropOffRequest $request)
    {
        $dropoff = DropOff::create($request->all());
        Rental::find($dropoff->rental_id)->update(["end_date" => Carbon::now() ]); // atualizando data de retorno do aluguel
        return $this->successResponse($dropoff, 201);
    }

    public function show(DropOff $dropoff)
    {
        return $this->successResponse($dropoff);
    }

    public function update(DropOffRequest $request, DropOff $dropoff)
    {
        $dropoff->update($request->all());
        return $this->successResponse($dropoff, 201);
    }

    public function destroy(DropOff $dropoff)
    {
        $dropoff->delete();
        return $this->successResponse($dropoff, 200);
    }
}

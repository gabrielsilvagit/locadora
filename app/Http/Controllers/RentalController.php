<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Rental;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\RentalRequest;
use App\Notifications\RentalNotification;
use Illuminate\Support\Facades\Notification;

class RentalController extends Controller
{
    use ApiResponser;
    public function index()
    {
        try{
            $rentals = Rental::all();
            return $this->successResponse($rentals);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function store(RentalRequest $request)
    {
        try {
            $rental = Rental::create($request->all());
            $user = User::where('id', '=', $rental->user_id)->first();
            Notification::send($user, new RentalNotification());
            return $this->successResponse($rental, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
    public function update(RentalRequest $request, Rental $rental)
    {
        try {
            $rental->update($request->all());
            return $this->successResponse($rental, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function destroy(Rental $rental)
    {
        try {
            $rental->delete();
            return $this->successResponse($rental, 200);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
}

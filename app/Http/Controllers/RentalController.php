<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Rental;
use App\Vehicle;
use Carbon\Carbon;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RentalRequest;
use App\Services\AvailabilityService;
use App\Notifications\RentalNotification;
use Illuminate\Support\Facades\Notification;

class RentalController extends Controller
{
    protected $AvailabilityService;
    use ApiResponser;

    public function __construct(AvailabilityService $AvailabilityService)
    {
        $this->AvailabilityService = $AvailabilityService;
    }

    public function index()
    {

        $rentals = Rental::all();
        return $this->successResponse($rentals);
    }

    public function store(RentalRequest $request)
    {
        DB::beginTransaction();
        try {
            $newRental = $request->all();
            $available = $this->AvailabilityService->available($newRental['category_id'], $newRental['start_date'], $newRental['end_date']);
            if($available){
                $rental = Rental::create($newRental);
                DB::commit();
                $user = User::where('id','=',$newRental['user_id'])->first();
                Notification::send($user, new RentalNotification());
                return $this->successResponse($rental, 201);
            }
            return $this->errorResponse('Error',400);
        }catch(Exception $exception) {
            DB::rollBack();
            return $this->errorResponse('error',400);
        }
    }

    public function show(Rental $rental)
    {
        return $this->successResponse($rental);
    }

    public function update(RentalRequest $request, Rental $rental)
    {
        try {
            $newRental = $request->all();
            $available = $this->AvailabilityService->available($newRental['category_id'], $newRental['start_date'], $newRental['end_date']);
            if($available){
                $rental->update($newRental);
                DB::commit();
                $user = User::where('id','=',$newRental['user_id'])->first();
                Notification::send($user, new RentalNotification());
                return $this->successResponse($rental, 201);
            }
            return $this->errorResponse('error',400);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();
        return $this->successResponse($rental, 200);
    }
}

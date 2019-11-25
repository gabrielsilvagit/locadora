<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Rental;
use Carbon\Carbon;
use App\Traits\ApiResponser;
use App\Services\CategoryService;
use App\Services\SettingsService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RentalRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\AvailabilityService;
use App\Notifications\RentalNotification;
use Illuminate\Support\Facades\Notification;

class RentalController extends Controller
{
    protected $availabilityService;
    protected $categoryService;
    protected $settingsService;

    use ApiResponser;

    public function __construct(
        AvailabilityService $availabilityService,
        CategoryService $categoryService,
        SettingsService $settingsService
    ) {
        $this->availabilityService = $availabilityService;
        $this->settingsService = $settingsService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $rentals = Rental::all();

        return $this->successResponse($rentals);
    }

    public function store(RentalRequest $request)
    {
        $category = $request->category_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $free_km = $request->free_km;
        $under25 = $request->under_25;

        if (!Carbon::parse($endDate)->gt($startDate)) {
            return $this->errorResponse('End date must be greater than start date', 422);
        }

        $available = $this->availabilityService->checkAvaliability($category, $startDate, $endDate);

        if (!$available) {
            return $this->errorResponse('There is no vehicles available for the given dates', 403);
        }

        $dailyRate = $this->categoryService->getDailyRate($category, $free_km);
        $ageTax = 0;
        if ($under25) {
            $ageTax = $this->settingsService->getAgeTax($category, $free_km);
            $dailyRate += $dailyRate * ($ageTax/100);
        }

        $rentalData = [
            "type" => 'rent',
            "user_id" => $request->user_id ? $request->user_id : Auth::id(),
            "category_id" => $category,
            "start_date" => $startDate,
            "end_date" => $endDate,
            "daily_rate" => $dailyRate,
            "notes" => $request->notes,
            "free_km" => $free_km,
            "age_aditional" => $ageTax
        ];

        $rental = Rental::create($rentalData);

        $user = User::where('id', '=', $rentalData['user_id'])->first();
        Notification::send($user, new RentalNotification());

        /** UPDATE **/
        // km atual insert por usuario
        // fuel level insert por usuario

        return $this->successResponse($rental, 201);
    }

    public function show(Rental $rental)
    {
        return $this->successResponse($rental);
    }

    public function update(RentalRequest $request, Rental $rental)
    {
        $category = $request->category_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $free_km = $request->free_km;
        $under25 = $request->under_25;

        if (!Carbon::parse($endDate)->gt($startDate)) {
            return $this->errorResponse('End date must be greater than start date', 422);
        }

        $available = $this->availabilityService->checkAvaliability($category, $startDate, $endDate);

        if (!$available) {
            return $this->errorResponse('There is no vehicles available for the given dates', 403);
        }

        $dailyRate = $this->categoryService->getDailyRate($category, $free_km);
        $ageTax = 0;
        if ($under25) {
            $ageTax = $this->settingsService->getAgeTax($category, $free_km);
            $dailyRate += $dailyRate * ($ageTax/100);
        }

        $rentalData = [
            "type" => 'rent',
            "user_id" => $request->user_id ? $request->user_id : Auth::id(),
            "category_id" => $category,
            "start_date" => $startDate,
            "end_date" => $endDate,
            "daily_rate" => $dailyRate,
            "notes" => $request->notes,
            "free_km" => $free_km,
            "age_aditional" => $ageTax
        ];

        $rental->update($rentalData);

        $user = User::where('id', '=', $rentalData['user_id'])->first();
        Notification::send($user, new RentalNotification());

        /** UPDATE **/
        // km atual insert por usuario
        // fuel level insert por usuario

        return $this->successResponse($rental, 201);
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();

        return $this->successResponse($rental, 200);
    }
}

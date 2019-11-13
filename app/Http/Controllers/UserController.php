<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Support\Str;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\Mail\UserCreatePassword;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PasswordNotification;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    use ApiResponser;
    public function index()
    {
        try{
            $users = User::all();
            return $this->successResponse($users);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }
    public function store(UserRequest $request)
    {
        try {
            $token = Str::random(64);
            $user = User::create($request->all());
            $user->remember_token = $token;
            $user->save();
            Notification::send($user, new PasswordNotification($token));
            return $this->successResponse($user, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function update(UserRequest $request, User $user)
    {
        try{
            $user->update($request->all());
            return $this->successResponse($user, 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error', 400);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return $this->successResponse($user);
        } catch (Exceptio $e) {
            return $this->errorResponse('Error', 400);
        }
    }

}

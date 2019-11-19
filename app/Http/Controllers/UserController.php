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
        $users = User::all();
        return $this->successResponse($users);
    }
    public function store(UserRequest $request)
    {
        $token = Str::random(64); // email token for password request

        $user = User::create($request->all());
        $user->remember_token = $token;
        $user->save();

        Notification::send($user, new PasswordNotification($token)); // send email to user with password token

        return $this->successResponse($user, 201);
    }

    public function show(User $user)
    {
        return $this->successResponse($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $newUser=$request->all();
        $password = $newUser['password'];
        $password = Hash::make($password);
        $newUser['password']=$password;
        $user->update($newUser);
        return $this->successResponse($user, 201);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->successResponse($user);
    }

}

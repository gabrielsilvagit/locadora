<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;

    public function index()
    {
    }

    public function login(LoginRequest $request)
    {
        $user = $request->all();
        if ($token = Auth::attempt($user)) {
            return $this->successResponse($token);
        }

        return $this->errorResponse('Incorrect Credentials', 400);
    }

    public function logout()
    {
        Auth::logout();

        return $this->successResponse('Logout');
    }
}

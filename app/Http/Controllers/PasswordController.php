<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PasswordRequest;

class PasswordController extends Controller
{
    use ApiResponser;
    public function create(PasswordRequest $request, $token)
    {
        try {
            $password=$request->all();
            $data= Hash::make($password['password']);
            $user = User::where("remember_token", $token)->first();
            $user->password = $data;
            $user->save();
            return $this->successResponse($user, 201);
        } catch(Exception $e) {
            return $this->errorResponse('Erro', 400);
        }
    }
}

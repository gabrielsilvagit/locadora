<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        return response()->json(['data' => $user->toArray()], 201);
    }

}

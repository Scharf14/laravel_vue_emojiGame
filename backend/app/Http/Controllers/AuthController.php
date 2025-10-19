<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        Auth::login($user);

        return response()->json($user);
    }

    public function login(AuthUserRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            return response()->json($credentials);
        }
    }
}

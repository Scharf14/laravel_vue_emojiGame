<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $token = Str::random(10);

        $user->token = $token;

        $user->save();

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'registration successful'
        ], 201);
    }

    public function login(AuthUserRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'the user does not exist'
            ], 404);
        }

        $token = Str::random(10);

        $user->token = $token;

        $user->save();

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'You have logged in successfully.'
        ]);
    }

    public function logout()
    {
        User::updated(['token' => null]);

        return response()->json([
            'message' => 'you logged out successfully'
        ]);
    }
}

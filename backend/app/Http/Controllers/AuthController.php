<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Models\UserStat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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


        $userStat = $user->userStat()->create(['level' => 1, 'experience'=>0]);

        Storage::disk('local')->put('example.png', 'Contents');


        $user->save();

        return response()->json([
            'stat' => $userStat,
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

        $userStat = $user->userStat;

        $user->save();
        return response()->json([
            'stat' => $userStat,
            'user' => $user,
            'token' => $token,
            'message' => 'You have logged in successfully.'
        ]);
    }

    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            $user->update(['token' => null]);
        }

        return response()->json([
            'message' => 'you logged out successfully'
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $stats = $user->userStat;
//        dd($avatar);

        return response()->json([
           'user' => $user,
           'stats' => $stats,
        ]);
    }
}

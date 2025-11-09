<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(AuthUserRequest $request)
    {
        return response()->json($request->user());
    }

}

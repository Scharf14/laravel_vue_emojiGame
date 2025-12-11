<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenValid
{

    public function handle(Request $request, Closure $next): Response
    {
        dd($request->header());
        $token = $request->header('Authorization');
        if ($token === null) {
            return response()->json([
                'message' => 'Your token is invalid(token===null)'
            ], 401);
        }
        $user = User::where('token', $token)->first();
          if ($user) {
            Auth::login($user);
            return $next($request);
        }
        return response()->json([
            'message' => 'Your token is invalid(!$user)'
        ], 401);

    }
}

<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenValid
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        if ($token === null) {
            return response()->json([
                'message' => 'Your token is invalid(token===null)'
            ], 401);
        }
        $user = User::where('token', $token)->first();
//        dd($user);

          if ($user) {
            Auth::login($user);
            return $next($request);
        }
        return response()->json([
            'message' => 'Your token is invalid(!$user)'
        ], 401);

    }
}

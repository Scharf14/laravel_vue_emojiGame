<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(\App\Http\Middleware\EnsureTokenValid::class);

Route::prefix('/auth',)->controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::post('/login', 'login' );
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->middleware(\App\Http\Middleware\EnsureTokenValid::class);
});







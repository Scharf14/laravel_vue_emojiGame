<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(\App\Http\Middleware\EnsureTokenValid::class);

Route::prefix('/auth')->controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->middleware(\App\Http\Middleware\EnsureTokenValid::class);
});

Route::prefix('/profile')->controller(\App\Http\Controllers\ProfileController::class)->middleware(\App\Http\Middleware\EnsureTokenValid::class)->group(function () {
    Route::post('/setAvatar', 'setAvatar');
    Route::get('/getAvatar', 'getAvatar');


});


Route::prefix('/game')->controller(\App\Http\Controllers\GameController::class)->middleware(\App\Http\Middleware\EnsureTokenValid::class)->group(function () {
    Route::get('/getGameData', 'getGameData');
    Route::get('/getFrame/{film}', 'getFrame');
    Route::get('/getFilm', 'getFilm');
    Route::get('/getStatistics', 'getStatistics');
    Route::post('/saveStatistics', 'saveStatistics');

});

Route::prefix('/admin')->controller(\App\Http\Controllers\AdminController::class)->group(function () {
    Route::post('/film', 'film');
});












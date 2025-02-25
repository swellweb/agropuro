<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FarmersController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('throttle:api');;

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/farmers', [FarmersController::class, 'getFarmers']);
});

Route::middleware('auth')->group(function () {
    Route::post('/update-password', [PasswordController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

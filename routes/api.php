<?php

use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\FarmersController;




Route::post('/register', [RegisteredUserController::class, 'store'])->name('api.register');
//Route::post('/login', [LoginController::class, 'login'])->name('api.login');


// API Route per ottenere tutti gli utenti che sono agricoltori
Route::get('/farmers', [FarmersController::class, 'getFarmers']);

Route::post('/check-email', function (Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    $emailExists = User::where('email', $request->email)->exists();

    return response()->json(['exists' => $emailExists]);
});

Route::post('/update-password', [PasswordController::class, 'updatePassword']);

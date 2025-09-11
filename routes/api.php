<?php

use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\FarmersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::post('/register', [RegisteredUserController::class, 'store'])->name('api.register');

// Rotta per controllare se l'email esiste già
Route::post('/check-email', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $emailExists = User::where('email', $request->email)->exists();

    return response()->json(['exists' => $emailExists]);
});

// Rotte protette con Sanctum
Route::middleware(['auth:sanctum'])->group(function () {

    // Recupera tutti gli agricoltori (solo utenti autenticati)
    Route::get('/farmers', [FarmersController::class, 'getFarmers']);

    // Aggiornare la password dell'utente autenticato
    Route::post('/update-password', [PasswordController::class, 'updatePassword']);

    // Effettuare il logout
    Route::post('/logout', function (Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout effettuato con successo']);
    });

    // Ottenere i dati dell'utente autenticato
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});

// Login API (NON protetta perché serve per ottenere il token)
Route::post('/login', function (Request $request) {
    Log::debug('login');
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenziali non valide'], 401);
    }

    return response()->json([
        'access_token' => $user->createToken('auth_token')->plainTextToken,
        'token_type' => 'Bearer',
        'user' => $user,
    ]);
});


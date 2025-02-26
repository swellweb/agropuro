<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Usa la tabella `users`
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
         ]);
         $role = \App\Models\Role::where('name', $request->role)->first();

         if ($role) {
            $user->roles()->syncWithoutDetaching($role->id); // Assegna il ruolo all'utente
         }


        return response()->json(['message' => 'Registrazione completata!'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            Log::info('Autenticazione riuscita per user ID: ' . Auth::id());
            $request->session()->regenerate();
            Log::info('Sessione rigenerata. Autenticato: ' . (Auth::check() ? 'Sì' : 'No'));

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            // Ritorna una risposta JSON con il redirect
            return response()->json([
                'message' => 'Login successful',
                'redirect' => route('dashboard'),
                'token' => $token, // Opzionale
            ]);
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

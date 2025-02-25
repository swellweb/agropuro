<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utenti,email', // Usa la tabella `utenti`
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string', // Ruolo dell'utente
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'Registrazione completata!'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            \Log::info('Autenticazione riuscita per user ID: ' . Auth::id());
            $request->session()->regenerate();
            \Log::info('Sessione rigenerata. Autenticato: ' . (Auth::check() ? 'Sì' : 'No'));

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

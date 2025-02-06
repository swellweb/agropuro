<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class PasswordController extends Controller
{
    public function updatePassword(Request $request)

    {

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Deve essere confermata con new_password_confirmation
        ]);

        $user = User::find(Auth::id()); //

        if (!$user) {
            return response()->json([
                'message' => 'Utente non trovato'
            ], 404);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'La vecchia password non è corretta'
            ], 403);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'Password aggiornata con successo'
        ], 200);
    }
}

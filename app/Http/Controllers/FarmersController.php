<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FarmersController extends Controller
{
    /**
     * Get all farmers with their related user data.
     *
     */

    public function index()
    {
        // Effettua una join tra la tabella users e farmers utilizzando il modello
        $farmers = User::where('role', 'farmer')
            ->join('farmers', 'utenti.id', '=', 'farmers.user_id')
            ->select(
                'utenti.id',
                'utenti.name',
                'utenti.email',
                'farmers.latitude',
                'farmers.longitude',
                'farmers.farm_name',
                'farmers.product'
            )
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('home', ['farmers' => $farmers]);
    }




    /**
     * Get all farmers with their related user data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFarmers()
    {
        // Effettua una join tra la tabella users e farmers utilizzando il modello
        $farmers = User::where('role', 'farmer')
            ->join('farmers', 'utenti.id', '=', 'farmers.user_id')
            ->select(
                'utenti.name',
                'utenti.email',
                'farmers.latitude',
                'farmers.longitude',
                'farmers.farm_name',
                'farmers.product'
            )
            ->get();

        return response()->json($farmers);
    }




public function store(Request $request)
{
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'farm_name' => 'required|string|max:255',
        'product' => 'required|string|max:255',
        // altri campi
    ]);

    // Genera un alias univoco di 6 caratteri alfanumerici
    do {
        $alias = Str::upper(Str::random(6)); // Genera un alias di 6 caratteri alfanumerici
    } while (Farmer::where('alias', $alias)->exists());

    $validatedData['alias'] = $alias;
     // Crea la cartella per l'utente

     $path = storage_path('app/public/storefarm/' . $alias);
     if (!file_exists($path)) {
         mkdir($path, 0777, true);
     }

    Farmer::create($validatedData);

    return redirect()->route('farmers.index')->with('success', 'Profilo agricoltore creato con successo!');
}
}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // Recupera fino a 6 agricoltori casuali dal database
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
}

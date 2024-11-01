<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapFarmController extends Controller
{
    public function index()
    {
        // Recuperare i dati degli agricoltori dal database (se necessario)
        $farmers = []; // Esegui una query qui per recuperare i dati veri
        return view('mapfarm', compact('farmers'));
    }
}

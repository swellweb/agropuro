<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $farmers = User::where('role', 'farmer')
        ->join('farmers', 'users.id', '=', 'farmers.user_id')
        ->select(
            'users.id',
            'users.name',
            'users.email',
            'farmers.latitude',
            'farmers.longitude',
            'farmers.farm_name',
        )
        ->inRandomOrder()
        ->limit(6)
        ->get();

        return view('home', ['farmers' => $farmers]);
    }
}

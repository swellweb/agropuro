<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmer;

class CrowdfundingController extends Controller
{
    public function index()
    {
        return view('crowdfunding',[]);
    }
}

<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    /**
     * Store a newly created donation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Devi essere loggato per fare una donazione.');
        }

        // Validate the request
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Create a new donation
        Donation::create([
            'user_id' => Auth::id(),
            'amount' => $request->input('amount'),
            'donor_name' => Auth::user()->name,
            'donor_email' => Auth::user()->email,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Grazie per la tua donazione!');
    }
}

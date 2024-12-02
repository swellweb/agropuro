<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

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

    /**
     * Crea una sessione di pagamento Stripe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCheckoutSession(Request $request)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Devi essere loggato per fare una donazione.'], 401);
        }

        // Validate the request
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Configura Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Crea una sessione di pagamento
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Donazione',
                        ],
                        'unit_amount' => $request->amount * 100, // Converti in centesimi
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('donation.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('donation.cancel', [], true),
            ]);

            // Ritorna l'ID della sessione di pagamento
            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Errore durante la creazione della sessione di pagamento: ' . $e->getMessage()], 500);
        }
    }

}

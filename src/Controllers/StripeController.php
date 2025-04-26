<?php

namespace Smarttech\StripePayment\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Stripe\Stripe;
use Stripe\Charge;

class StripeController extends Controller
{
    public function index()
    {
        return view('stripe::stripe');
    }

//     public function processPayment(Request $request)
//     {
//         Stripe::setApiKey(env('STRIPE_SECRET'));
//         try{


//         Charge::create([
//             'amount' => 100 * 100, // ₹100
//             'currency' => 'inr',
//             'source' => $request->stripeToken,
//             'description' => 'Test Payment',
//         ]);

//         return redirect()->route('stripe.success');
//     } catch (\Exception $e) {
//         return redirect()->route('stripe.cancel')->with('error', $e->getMessage());
//     }
// }
public function processPayment(Request $request)
{
    Stripe::setApiKey(env('STRIPE_SECRET'));

    try {
        Charge::create([
            'amount' => $request->amount * 100, // amount in paise
            'currency' => 'inr',
            'source' => $request->stripeToken,
            'description' => 'Payment for Product ID: ' . $request->product_id,
        ]);

        // Optional: Update Order Status here

        return redirect()->route('stripe.success');

    } catch (\Exception $e) {
        return redirect()->route('stripe.cancel')->with('error', $e->getMessage());
    }
}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripeController extends Controller
{
    public function stripeCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0.1',
            'description' => 'required|string',
            'stripe_id' => 'required|string',
            'price_id' => 'required|string'
        ]);




        $stripe = new StripeClient(env('STRIPE_SECRET'));


        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to subscribe.');
        }
        if (!$user->stripe_id) {
            $customer = $stripe->customers->create([
                'email' => $user->email,
                'name' => $user->name,
            ]);
            $user->update(['stripe_id' => $customer->id]);
        }
        // Now we can safely create a Checkout Session
        $response = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price' => $request->price_id,
                    'quantity' => 1,
                ],
            ],
            'mode' => 'subscription',
            'success_url' => route('stripe.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('plans.index'),
            'customer_email' => auth()->user()->email ?? 'guest@example.com',
        ]);

        return redirect($response['url']);
    }
    public function stripeCheckoutSuccess(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string'
        ]);

        $stripe = new StripeClient(env('STRIPE_SECRET'));

        try {
            $session = $stripe->checkout->sessions->retrieve($request->session_id);

            if (!$session) {
                return redirect()->route('products.index')->with('error', 'Invalid session ID.');
            }

            // Store payment details in the database if needed
            return redirect()->route('plans.index')->with('success', 'Payment successful.');
        } catch (\Exception $e) {
            return redirect()->route('plans.index')->with('error', 'Payment verification failed.');
        }
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;
use App\Models\subscription;

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
            'metadata' => [
                'plan_id' => $request->price_id,
                'userId' => auth()->user()->id
            ]

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

    public function webhook(Request $request)
    {
        $endpoint_secret ='whsec_70c327283437afe2c00240a560f56dc145a9d1fbde2ed6c298f0589c3e94f17c'; // Use webhook secret, not STRIPE_SECRET

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        if (!$sig_header) {
            return response()->json(['error' => 'Missing signature header'], 400);
        }

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            Log::info('Received Stripe event:', ['error' => 'Invalid payload']);
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::info('Received Stripe event:',['error' => 'Invalid signature']);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Log incoming event
        Log::info('Received Stripe event:', ['event' => $event]);

        switch ($event->type) {
            case 'customer.subscription.created':
            case 'invoice.payment_succeeded':
                $subscription = $event->data->object;

                    Subscription::create([
                        'subscription_id' => $subscription->id,
                        'plan_price_id' => $subscription->plan->id ?? null,
                        'plan_amount' => $subscription->plan->amount ?? null,
                        'plan_duration' => $subscription->plan->interval ?? null,
                        'plan_duration_count' => $subscription->plan->interval_count ?? null,
                        'subscription_type' => $subscription->plan->product ?? null,
                        'plan_duration_start' => date('Y-m-d H:i:s', $subscription->current_period_start),
                        'plan_duration_end' => date('Y-m-d H:i:s', $subscription->current_period_end),
                    ]);
                    break;
            default:
                Log::warning('Received unknown Stripe event type: ' . $event->type);
                }


        return response()->json(['message' => 'Webhook received'], 200);
    }

}

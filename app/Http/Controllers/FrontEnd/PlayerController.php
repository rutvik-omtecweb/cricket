<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\User;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    //Members can become players by making a payment
    public function joinPlayer(Request $request)
    {
        $user_id = $request->user_id;
        $amount = $request->amount;

        if (!$user_id || !$amount) {
            return response()->json(['status' => false, 'message' => 'Something went wrong!!']);
        }

        $existing_player = Player::where('user_id', $user_id)->where('status', 'success')->first();
        if (!empty($existing_player)) {
            return response()->json(['status' => false, 'message' => 'You have already been marked as a player.']);
        }

        // Proceed with your logic

        $stripe_secret = env('STRIPE_SECRET');
        $player = Player::create([
            'user_id' => $user_id,
            'payment_type' => "stripe",
            'amount' => $amount,
            'status' => 'pending'
        ]);

        $user = User::findOrFail($user_id);

        $stripe = new \Stripe\StripeClient($stripe_secret);
        $redirectUrl = route('stripe.checkout.success.player', ['id' => $player->id]) . '?session_id={CHECKOUT_SESSION_ID}';
        $cancel_url = route('stripe.checkout.cancel.player', ['id' => $player->id]);
        $user_name = $user->first_name . ' ' . $user->last_name . ' (Become Player)';

        $current_currency =
            $response =  $stripe->checkout->sessions->create([
                'success_url' => $redirectUrl,
                'cancel_url' => $cancel_url,
                'payment_method_types' => ['card'],
                'billing_address_collection' => 'required',
                'line_items' => [
                    [
                        'price_data'  => [
                            'product_data' => [
                                'name' => $user_name,
                            ],
                            'unit_amount'  => 100 * $amount,
                            'currency'     => 'usd',
                        ],
                        'quantity'    => 1
                    ],
                ],
                'mode' => 'payment',
            ]);

        if ($response['url']) {
            return response()->json(['url' => $response->url, 'status' => true]);
        } else {
            return response()->json(['status' => false, "message" => "Something went wrong!!"]);
        }
    }

    public function playerStripeCheckoutSuccess(Request $request, $id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);
        info($session);

        if ($session['status'] == 'complete') {

            $payment = Player::findOrFail($id);
            $payment->status = "success";
            $payment->transaction_id = $request->session_id;
            $payment->save();

            return redirect('/')->with('message', 'Payment successful. You are now a player!');
        } else {
            $payment = Player::findOrFail($id);
            $payment->status = "cancel";
            $payment->save();
            return redirect('/')->with('message', 'Payment has been Cancel');
        }
    }

    public function playerStripeCheckoutCancel(Request $request, $id)
    {
        $payment = Player::findOrFail($id);
        $payment->status = "cancel";
        $payment->save();

        return redirect()->back();
    }
}

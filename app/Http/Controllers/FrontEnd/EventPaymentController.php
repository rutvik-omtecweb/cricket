<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EventPayment;
use Illuminate\Support\Facades\Auth;

class EventPaymentController extends Controller
{
    public function purchaseTeam(Request $request)
    {
        $data = $request->all();
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->active()->verify()->first();
        if (empty($user)) {
            return response()->json(['status' => false, "message" => "Member not found or not verified."]);
        }

        $event_payment = EventPayment::where('user_id', $user_id)->where('event_id', $data['event_id'])->where('payment_for', 'purchase_team')->where('status', 'success')->first();
        if (empty($event_payment)) {
            $event = Event::findOrFail($data['event_id']);

            $payment = EventPayment::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'payment_type' => 'stripe',
                'amount' => $event->team_price,
                'payment_for' => 'purchase_team',
                'status' => "pending"
            ]);

            $stripe_secret = env('STRIPE_SECRET');
            $stripe = new \Stripe\StripeClient($stripe_secret);
            $redirectUrl = route('stripe.event.purchase.team.success', ['id' => $payment->id]) . '?session_id={CHECKOUT_SESSION_ID}';
            $cancel_url = route('stripe.event.payment.cancel', ['id' => $payment->id]);
            $user_name = ucwords($user->first_name . ' ' . $user->last_name) . ' - Purchase Team';
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
                                'unit_amount'  => 100 * $event->team_price,
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
        } else {
            return response()->json(['status' => false, "message" => "You have already purchased the team. You cannot make a second payment."]);
        }
    }

    public function stripePurchaseTeamSuccess(Request $request, $id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);
        info($session);

        if ($session['status'] == 'complete') {

            $payment = EventPayment::findOrFail($id);
            $payment->status = "success";
            $payment->transaction_id = $request->session_id;
            $payment->save();

            $event = Event::where('id', $payment->event_id)->first();
            $event->limit_number_of_team = $event->limit_number_of_team - 1;
            $event->save();

            return redirect()->route('event.detail', $payment->event_id)->with('message', 'Your payment has been successfully processed.');
        } else {
            $payment = EventPayment::findOrFail($id);
            $payment->status = "cancel";
            $payment->save();
            return redirect('/')->with('message', 'Payment has been Cancel');
        }
    }

    public function stripeEventPaymentCancel(Request $request, $id)
    {
        $payment = EventPayment::findOrFail($id);
        $payment->status = "cancel";
        $payment->save();

        return redirect()->back();
    }

    public function joinParticipant(Request $request)
    {
        $data = $request->all();
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->active()->verify()->first();
        if (empty($user)) {
            return response()->json(['status' => false, "message" => "Member not found or not verified."]);
        }

        $event = Event::findOrFail($data['event_id']);

        $payment = EventPayment::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'payment_type' => 'stripe',
            'amount' => $event->team_price,
            'payment_for' => 'participant',
            'status' => "pending"
        ]);

        $stripe_secret = env('STRIPE_SECRET');
        $stripe = new \Stripe\StripeClient($stripe_secret);
        $redirectUrl = route('stripe.event.join.participant.success', ['id' => $payment->id]) . '?session_id={CHECKOUT_SESSION_ID}';
        $cancel_url = route('stripe.event.payment.cancel', ['id' => $payment->id]);
        $user_name = ucwords($user->first_name . ' ' . $user->last_name) . ' - Participant';
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
                            'unit_amount'  => 100 * $event->team_price,
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

    public function stripeJoinParticipantSuccess(Request $request, $id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);
        info($session);

        if ($session['status'] == 'complete') {

            $payment = EventPayment::findOrFail($id);
            $payment->status = "success";
            $payment->transaction_id = $request->session_id;
            $payment->save();

            return redirect()->route('event.detail', $payment->event_id)->with('message', 'Your payment has been successfully processed.');
        } else {
            $payment = EventPayment::findOrFail($id);
            $payment->status = "cancel";
            $payment->save();
            return redirect('/')->with('message', 'Payment has been Cancel');
        }
    }
}

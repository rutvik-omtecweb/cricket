<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TeamPayment;
use App\Models\Player;
use App\Models\Payment;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $check_player = TeamMember::pluck('member_id');
        $player = Player::whereNotIn('user_id', $check_player)->where('status', 'success')->get();
        return view('frontend.buy_team', compact('player'));
    }

    public function teamStore(Request $request)
    {
        $data = $request->all();
        $user =  Auth::user();
        $request->validate([
            'team_name' => 'required|unique:teams,team_name,id',
        ]);

        $payment = Payment::where('title', 'Team Registration Fees')->first();

        if (empty($payment)) {
            return response()->json(['status' => false, "message" => "Failed to retrieve payment amount. Please try again later."]);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'storage/teams';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        }

        $data['image'] = $image_name;
        $data['user_id'] = $user->id;
        $team = Team::create($data);
 
        if (isset($request->member_id)) {
            foreach ($request->member_id as $key => $member) {
                TeamMember::create([
                    'team_id' => $team->id,
                    'member_id' => $member
                ]);
            }
        }

        $stripe_secret = env('STRIPE_SECRET');

        

        //stripe payment
        $amount = $payment->amount;

        $payment = TeamPayment::create([
            'user_id' => $user->id,
            'team_id' => $team->id,
            'payment_type' => "stripe",
            'amount' => $amount,
            'status' => 'pending'
        ]);

        $stripe = new \Stripe\StripeClient($stripe_secret);
        $redirectUrl = route('stripe.checkout.success', ['id' => $payment->id]) . '?session_id={CHECKOUT_SESSION_ID}';
        $cancel_url = route('stripe.checkout.cancel', ['id' => $payment->id]);
        $user_name = $user->first_name . ' ' . $user->last_name;
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

        // return redirect()->route('buy.team')->with('message', 'Team has been successfully created.');
    }
}

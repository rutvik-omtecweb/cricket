<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Team;
use App\Models\User;
use App\Models\Player;
use App\Models\Payment;
use App\Models\TeamMember;
use App\Models\TeamPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TeamController extends Controller
{
    public function index()
    {
        $check_player = TeamMember::pluck('member_id');
        // $player = Player::whereNotIn('user_id', $check_player)->where('user_id', '!=', @Auth::user()->id)->where('status', 'success')->get();
        $player = Player::whereNotIn('id', $check_player)->where('id', '!=', @Auth::user()->id)->where('status', 'success')->get();
        return view('frontend.buy_team', compact('player'));
    }

    public function teamStore(Request $request)
    {
        $data = $request->all();
        $user =  Auth::user();
        $data['user'] = Auth::user();
        $request->validate([
            'team_name' => 'required|unique:teams,team_name,id',
        ]);

        // Validate if at least one player is selected
        if (empty($request->member_id)) {
            return response()->json(['status' => false, "message" => "Please select at least one player."]);
        }

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

        if ($payment->amount == 0) {

            $data['image'] = $image_name;
            $data['user_id'] = $user->id;
            $team = Team::create($data);

            $t_payment = TeamPayment::create([
                'user_id' => $user->id,
                'team_id' => $team->id,
                'payment_type' => "free",
                'amount' => $payment->amount,
                'status' => 'success'
            ]);

            if (isset($request->member_id)) {
                foreach ($request->member_id as $key => $member) {
                    TeamMember::create([
                        'team_id' => $team->id,
                        'member_id' => $member
                    ]);
                }
            }
            $redirect_url = route('home');
            Session::flash('message', 'Payment successful. Team has been successfully created.');
            return response()->json([
                'url' => $redirect_url,
                'status' => true
            ]);
        } else {

            $stripe_secret = env('STRIPE_SECRET');

            //stripe payment
            $amount = $payment->amount;

            $t_payment = TeamPayment::create([
                'user_id' => $user->id,
                // 'team_id' => $team->id,
                'payment_type' => "stripe",
                'amount' => $amount,
                'status' => 'pending'
            ]);

            $request->session()->put('team_name', $request->input('team_name'));
            $request->session()->put('member_id', $request->input('member_id'));
            $request->session()->put('image', $image_name);
            $request->session()->put('description', $request->input('description'));

            $stripe = new \Stripe\StripeClient($stripe_secret);
            $redirectUrl = route('stripe.checkout.success.team', ['id' => $t_payment->id]) . '?session_id={CHECKOUT_SESSION_ID}';
            $cancel_url = route('stripe.checkout.cancel.team', ['id' => $t_payment->id]);
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
        }



        // return redirect()->route('buy.team')->with('message', 'Team has been successfully created.');
    }

    public function teamStripeCheckoutSuccess(Request $request, $id)
    {
        // dd($request->all());
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);
        info($session);

        $team_name = $request->session()->get('team_name');
        $member_id = $request->session()->get('member_id');
        $image = $request->session()->get('image');
        $description = $request->session()->get('description');


        if ($session['status'] == 'complete') {

            $data = $request->all();

            $payment = TeamPayment::findOrFail($id);
            $payment->status = "success";
            $payment->transaction_id = $request->session_id;
            $payment->save();

            $team = Team::create([
                'team_name' => @$team_name,
                'description' => @$description,
                'image' => @$image,
                'user_id' => @$payment->user_id
            ]);

            $payment->team_id = $team->id;
            $payment->save();

            if (isset($member_id)) {
                foreach ($member_id as $key => $member) {
                    TeamMember::create([
                        'team_id' => $team->id,
                        'member_id' => $member
                    ]);
                }
            }

            return redirect('/')->with('message', 'Payment successful. Team has been successfully created.');
        } else {
            $payment = TeamPayment::findOrFail($id);
            $payment->status = "cancel";
            $payment->save();
            return redirect('/')->with('message', 'Payment has been Cancel');
        }
    }

    public function teamStripeCheckoutCancel(Request $request, $id)
    {
        $payment = TeamPayment::findOrFail($id);
        $payment->status = "cancel";
        $payment->save();

        return redirect('/')->with('message', 'Payment has been Cancel');
    }
}

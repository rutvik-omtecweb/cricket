<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\SendMail;
use App\Models\Payment;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Models\PaymentCollect;
use Illuminate\Support\Carbon;
use App\Models\BusinessSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Spatie\Newsletter\Facades\Newsletter;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    // protected function create(array $data, Request $request)
    // {
    //     $user_token = Str::random(64);

    //     $data['temp_token'] = $user_token;
    //     $data['verify_code'] = generateUniqueRandomNumber();

    //     $user =  User::create([
    //         'first_name' => $data['first_name'],
    //         'last_name' => $data['last_name'],
    //         'phone' => $data['phone'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //         'temp_token' => $user_token,
    //         'verify_code' => generateUniqueRandomNumber(),
    //         'is_active' =>false,
    //         'is_verified' => false,
    //         'newsletter_subscribe' => $data['newsletter_subscribe'] ?? false
    //     ]);

    //     $user->assignRole('customer');

    //     if (isset($data['newsletter_subscribe'])) {
    //         Newsletter::subscribe($data['email']);
    //     }

    //     $setting = BusinessSetting::where('key', 'email_notifications')->where('value', 1)->first();
    //         if (!empty($setting)) {
    //             $email_template = EmailTemplate::where('title', 'verify-account')->first();
    //             if (!empty($email_template)) {
    //                 $subject = $email_template['subject'];
    //                 $link = $request->root() . "/verify/email/" .  $user_token;
    //                 $full_name = $user->first_name . ' ' . $user->last_name;
    //                 $company_name = BusinessSetting::where('key', 'business_name')->first()->value;
    //                 $company_email = BusinessSetting::where('key', 'email_address')->first()->value;
    //                 $mail_data = str_replace('[full name]', $full_name, $email_template['content']);
    //                 $mail_data = str_replace('[company_name]', $company_name, $mail_data);
    //                 $mail_data = str_replace('[code]', $user->verify_code, $mail_data);
    //                 $mail_data = str_replace('[verification_link]', $link, $mail_data);
    //                 $mail_data = str_replace('[company_email]', $company_email, $mail_data);

    //                 $email = new SendMail($mail_data);
    //                 // Set the subject for the email
    //                 $email->subject($subject);
    //                 // Send the email
    //                 Mail::to($user->email)->send($email);
    //             }
    //         }

    //     return redirect()->route('landing')->with('message', 'Account Create Successfully.');
    // }

    public function userVerify($token)
    {
        $check_user = User::where('temp_token', $token)->first();
        return view('frontend.user-verify', compact('check_user'));
    }

    public function verify(Request $request)
    {
        $data = $request->all();

        $array1 = [$request->code];
        $string = null;
        foreach ($array1 as $a) {
            foreach ($a as $b => $c) {
                $string .= $c;
            }
        }
        if ($data['user_code'] == $string) {
            $user = User::findOrFail($data['id']);
            $user->update([
                'is_active' => true,
                'is_verified' => true,
            ]);
            return redirect()
                ->route('login')
                ->with('message', 'Your account verify successfully');
        } else {
            return redirect()
                ->route('userVerify', [$data['temp_token']])
                ->with('error', 'OTP not match!!, please try again');
        }
    }

    public function showRegistrationForm(Request $request)
    {
        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        $data = $request->all();
        $terms_and_conditions = isset($data['terms_and_conditions']) ? 1 : 0;
        $living_rmwb_for_3_month = isset($data['living_rmwb_for_3_month']) ? 1 : 0;
        $not_member_of_cricket = isset($data['not_member_of_cricket']) ? 1 : 0;
        $path = 'storage/member';

        if ($request->hasFile('verification_id_1')) {
            $file = $request->file('verification_id_1');
            $v1_image_name = 'v1_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $v1_image_name);
        }

        if ($request->hasFile('verification_id_2')) {
            $file2 = $request->file('verification_id_2');
            $v2_image_name = 'v2_' . time() . '_' . uniqid() . '.' . $file2->getClientOriginalExtension();
            $file2->move(public_path($path), $v2_image_name);
        }

        if ($request->hasFile('verification_id_3')) {
            $file3 = $request->file('verification_id_3');
            $v3_image_name = 'v3_' . time() . '_' . uniqid() . '.' . $file3->getClientOriginalExtension();
            $file3->move(public_path($path), $v3_image_name);
        }

        $payment = Payment::where('title', 'Member Registration Fees')->first();

        if (empty($payment)) {
            return response()->json(['status' => false, "message" => "Failed to retrieve payment amount. Please try again later."]);
        }

        $user = User::create([
            'user_name' => $data['user_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($request->password),
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'postal_code' => $data['postal_code'],
            'is_verify' => false,
            'is_active' => false,
            'terms_and_conditions' => $terms_and_conditions,
            'living_rmwb_for_3_month' => $living_rmwb_for_3_month,
            'not_member_of_cricket' => $not_member_of_cricket,
            'verification_id_1' => @$v1_image_name,
            'verification_id_2' => @$v2_image_name,
            'verification_id_3' => @$v3_image_name,
        ]);

        $user->assignRole('member');

        $stripe_secret = env('STRIPE_SECRET');

        //stripe payment
        $amount = $payment->amount;

        $payment = PaymentCollect::create([
            'user_id' => $user->id,
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

        // return redirect()
        //     ->route('login')
        //     ->with('message', 'Your registration was successful. Please check your email to verify your account.');
    }

    public function verifyUserAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;

            if ($verifyUser->expires_at < now()) {
                $message = "Your verification link has expired. Please request a new one.";
            } else {
                // Verify the user
                if (!$user->is_verify) {
                    $verifyUser->user->is_verify = true;
                    $verifyUser->user->is_active = true;
                    $verifyUser->user->save();
                    // $message = "Your e-mail is verified. Please wait for admin approval.";
                    $message = "Your e-mail is verified";
                } else {
                    // $message = "Your e-mail is already verified. Please wait for admin approval.";
                    $message = "Your e-mail is already verified";
                }
            }
        }

        return redirect()->route('login')->with('message', $message);
    }

    public function stripeCheckoutSuccess(Request $request, $id)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);
        info($session);

        if ($session['status'] == 'complete') {

            $payment_config = Payment::where('title', 'Member Registration Fees')->first();
            $expired_date = Carbon::now()->addDays($payment_config->days);

            $payment = PaymentCollect::findOrFail($id);
            $payment->status = "success";
            $payment->transaction_id = $request->session_id;
            $payment->expired_date = isset($expired_date) ? $expired_date : null;
            $payment->save();

            $token = Str::random(64);

            UserVerify::create([
                'user_id' => $payment->user_id,
                'token' => $token,
                'expires_at' => now()->addHours(1),
            ]);

            $setting = GeneralSetting::first();
            $user = User::findOrFail($payment->user_id);
            if ($user) {
                if ($setting) {
                    $email_template = EmailTemplate::where('title', 'Verify Member')->first();
                    if (!empty($email_template)) {
                        $subject = $email_template['subject'];
                        $link = $request->root() . "/user/verify/" .  $token;
                        $user_name = $user->first_name . ' ' . $user->last_name;

                        $verification_link = $request->root() . '/' . $user->is_verify;
                        $mail_data = str_replace('[name]', $user_name, $email_template['content']);
                        $mail_data = str_replace('[company_name]', $setting->site_name, $mail_data);
                        $mail_data = str_replace('[verification_link]', $link, $mail_data);
                        $mail_data = str_replace('[company_contact_info]', $setting->phone, $mail_data);
                        $mail_data = str_replace('[X]', '1', $mail_data);
                        $mail_data = str_replace('[Your Company Name]', $setting->site_name, $mail_data);

                        $email = new SendMail($mail_data);
                        // Set the subject for the email
                        $email->subject($subject);

                        // Send the email
                        Mail::to($user->email)->send($email);
                    }
                }
            }

            return redirect('/')->with('message', 'Payment successful. Please check your email to verify your account and admin approval');
        } else {
            $payment = PaymentCollect::findOrFail($id);
            $payment->status = "cancel";
            $payment->save();
            return redirect('/')->with('message', 'Order has been Cancel');
        }
    }

    public function stripeCheckoutCancel(Request $request, $id)
    {
        $payment = PaymentCollect::findOrFail($id);
        $payment->status = "cancel";
        $payment->save();

        return redirect()->back();
    }
}

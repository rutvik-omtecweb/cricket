<?php

namespace App\Http\Controllers\Auth;

use App\Models\City;
use App\Models\User;
use App\Mail\SendMail;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Models\CustomerAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    //admin login
    public function showAdminLoginForm()
    {
        return view('admin.auth.login', ['url' => route('admin.login-view'), 'title' => 'Admin']);
    }

    //admin login
    public function adminLogin(Request $request)
    {
        $user = User::where("email", $request->email)->first();
        $this->validateLogin($request);
        if ($user->is_active == 0) {
            return redirect()->route('admin.login')->with('message', '* These credentials do not match our records.');
        } else {

            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {
                $this->handleSuccessfulLogin($request);
                return $this->sendLoginResponse($request);
            }

            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->hasAnyRole(['super admin', 'admin'])) {
            return redirect('admin/dashboard');
        } else {
            return redirect('/');
        }
    }

    private function handleSuccessfulLogin($request)
    {
        if ($request->hasSession()) {
            $request->session()->put('auth.password_confirmed_at', time());
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            '* These credentials do not match our records.',
        ]);
    }

    public function userLogin(Request $request)
    {
        // Validate the login request
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to log in the user using either username or email
        $credentials = $request->only('login', 'password');
        $user = User::where('user_name', $credentials['login'])
            ->orWhere('email', $credentials['login'])
            ->first();

        // If user found and password is correct
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Check if the user is verified
            if ($user->is_verify == 1 && $user->is_approve == 1) {
                // Log in the user
                Auth::login($user);
                // return redirect()->route('home')->with('message', 'You have successfully logged in.');
                return redirect()->route('profile')->with('message', 'You have successfully logged in.');
            } else {
                // If user is not verified, redirect back with error message
                return back()->withInput()->withErrors(['login' => 'Your account is not verify or has not been approved yet']);
            }
        }


        // If authentication fails, redirect back with error message
        return back()->withInput()->withErrors(['login' => 'Invalid login or password.']);
    }

    public function resentVerification()
    {
        return view('auth.resend_verification');
    }

    public function resentVerificationSend(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            return redirect()->route('user.resend.verification')->with('error', 'Email do not match our records..');
        } else {
            if ($user->is_verify == 1) {
                return redirect()->route('user.resend.verification')->with('error', 'User is already verified.');
            } else {
                $token = Str::random(64);
                UserVerify::create([
                    'user_id' => $user->id,
                    'token' => $token,
                    'expires_at' => now()->addHours(1),
                    // 'expires_at' => now()->addMinutes(3),
                ]);

                //send vendor verification mail :start
                $setting = GeneralSetting::first();
                if ($user->id) {
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
                    //send vendor verification mail :end
                }

                return redirect()->route('login')->with('message', 'You have been successfully registered. Please check your email for further instructions.');
            }
        }
    }


    public function logout(Request $request)
    {
        $admin_role = $this->guard()->user()->hasAnyRole(['super admin', 'admin']);

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($admin_role) {
            return redirect('/admin');
        } else {
            return redirect('/')->with('message', 'You have been successfully logged out.');
        }
    }
}

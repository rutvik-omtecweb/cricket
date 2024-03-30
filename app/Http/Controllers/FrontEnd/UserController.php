<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\User;
use App\Models\Player;
use App\Models\Payment;
use App\Models\EventPayment;
use Illuminate\Http\Request;
use App\Models\PaymentCollect;
use App\Models\TeamPayment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profileIndex()
    {
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $user_payment = PaymentCollect::where('user_id', $userId)->first();
        $team_payment = TeamPayment::with('team.team_member')->where('user_id', $userId)->where('status', 'success')->first();
        $event_payments = EventPayment::with('event')->where('user_id', $userId)->where('status', 'success')->get();
        $player_payment = Player::where('user_id', $userId)->where('status', 'success')->first();
        return view('frontend.profile', compact('user', 'user_payment', 'event_payments', 'player_payment', 'team_payment'));
    }

    public function profileUpdate(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|numeric|digits:10|unique:users,phone,' . Auth::user()->id,
            'email' => 'required|unique:users,email,' . Auth::user()->id,
        ]);
        $user = User::findOrFail(Auth::user()->id);
        if ($request->hasFile('image')) {

            $pathRemove = 'storage/user/';
            $imageRemove = public_path($pathRemove . $user->getRawOriginal('image'));
            if (File::exists($imageRemove)) {
                File::delete($imageRemove);
            }

            $file = $request->file('image');
            $path = 'storage/user';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        } else {
            $old = explode('/', $request->oldimage);
            $image_name = $old[count($old) - 1];
        }
        $data['image'] = $image_name;

        $user->update($data);
        return back()->with("message", "Profile has been successfully updated");
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with("error", "Current Password is invalid!");
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->password),
        ]);
        return back()->with("message", "Password has been successfully updated.");
    }
}

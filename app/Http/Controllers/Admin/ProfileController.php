<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the admin's profile details.
     */
    public function profile(Request $request)
    {
        $data = User::findOrFail(Auth::user()->id);
        return view('admin.profile.profile', compact('data'));
    }

    /**
     * Update the admin's profile details.
     */
    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'user_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|numeric|digits:10|unique:users,phone,' . Auth::user()->id,
        ]);

        $path = 'storage/user';
        $user = User::findOrFail(Auth::user()->id);

        if ($request->hasFile('image')) {

            $pathRemove = 'storage/user/';
            $imageRemove = public_path($pathRemove . $user->getRawOriginal('image'));
            if (File::exists($imageRemove)) {
                File::delete($imageRemove);
            }

            $file = $request->file('image');
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        } else {
            $old = explode('/', $request->oldimage);
            $image_name = $old[count($old) - 1];
        }
        $data['image'] = $image_name;

        $user->update($data);
        return back()->with("message", "Your profile has been updated successfully!");
    }

    /**
     * Update the user's password.
     */

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required',
        ]);
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with("error", "The current password you entered is invalid.");
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with("message", "Your password has been changed successfully!");
    }
}

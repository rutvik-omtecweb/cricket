<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;

class ContactUsController extends Controller
{
    public function contactUs()
    {
        $general_setting = GeneralSetting::first();
        return view('frontend.contact_us', compact('general_setting'));
    }

    public function contactUsRequest(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'subject' => 'required',
            'full_name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        $data = $request->all();
        ContactUs::create($data);
        return redirect('/')->with('message', 'Contact request submit successfully.');
    }
}

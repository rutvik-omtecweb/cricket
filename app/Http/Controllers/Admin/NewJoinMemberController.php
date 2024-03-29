<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class NewJoinMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = GeneralSetting::first();
        return view('admin.member.new_index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * List New Join Members.
     */
    public function getNewMember(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];

        $records = User::role('member')->with('roles', 'payment_collect')->verify()->whereNull('is_approve');
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records;
            $records = $records->where(function ($query) use ($searchValue) {
                $query->where('user_name', 'LIKE', '%' . $searchValue . '%')->orWhere('first_name', 'LIKE', '%' . $searchValue . '%')->orWhere('last_name', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchValue . '%')->orWhere('phone', 'LIKE', '%' . $searchValue . '%')->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $searchValue . '%'])
                    ->orWhereHas('payment_collect', function ($q) use ($searchValue) {
                        $q->where('amount', 'LIKE', '%' . $searchValue . '%');
                    });
            });
        }

        $records = $records->latest()
            ->skip($start)
            ->take($row_per_page)
            ->get();

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $records ?? [],
        );

        return response()->json($response);
    }

    /**
     * approve and reject member.
     */
    public function toggleNewMember(Request $request, string $id)
    {
        $data = $request->all();
        $member = User::findOrFail($id);
        if ($member->is_reject == 1) {
            return response()->json(['success' => false, 'message' => 'Member is rejected. You must first cancel the rejection before approving.']);
        }

        $member->update([
            'is_approve' => !$member->is_approve,
        ]);

        if ($data['message'] == 'approve') {
            $setting = GeneralSetting::first();
            if ($member) {
                if ($setting) {
                    $email_template = EmailTemplate::where('title', 'Approve of Membership')->first();
                    if (!empty($email_template)) {
                        $subject = $email_template['subject'];
                        $user_name = $member->first_name . ' ' . $member->last_name;
                        $login = route('login');
                        $mail_data = str_replace('[User]', $user_name, $email_template['content']);
                        $mail_data = str_replace('[Website Name]', $setting->site_name, $mail_data);
                        $mail_data = str_replace('[Login URL]', $login, $mail_data);
                        $mail_data = str_replace('[Company]', $setting->email, $mail_data);

                        $email = new SendMail($mail_data);
                        // Set the subject for the email
                        $email->subject($subject);

                        // Send the email
                        Mail::to($member->email)->send($email);
                    }
                }
            }
        }

        if ($data['message'] == 'approve') {
            $message = 'Member Approve successfully';
        } else {
            $message = 'Member Approve cancelled successfully';
        }
        return response()->json(['success' => true, 'message' => $message]);
    }

    public function toggleRejectMember(Request $request, $id)
    {

        $data = $request->all();
        $member = User::findOrFail($id);
        $member->update([
            'is_reject' => !$member->is_reject,
            'rejection_reason' => @$data['reject_reason']
        ]);

        if ($data['email'] == 1) {
            $setting = GeneralSetting::first();
            if ($member) {
                if ($setting) {
                    $email_template = EmailTemplate::where('title', 'Rejection of Membership')->first();
                    if (!empty($email_template)) {
                        $subject = $email_template['subject'];
                        $user_name = $member->first_name . ' ' . $member->last_name;

                        $mail_data = str_replace('[User]', $user_name, $email_template['content']);
                        $mail_data = str_replace('[Website Name]', $setting->site_name, $mail_data);
                        $mail_data = str_replace('[reason]', $data['reject_reason'], $mail_data);
                        $mail_data = str_replace('[Company]', $setting->email, $mail_data);

                        $email = new SendMail($mail_data);
                        // Set the subject for the email
                        $email->subject($subject);

                        // Send the email
                        Mail::to($member->email)->send($email);
                    }
                }
            }
        }

        if ($data['email'] == 1) {
            $message = 'Member Rejected successfully';
        } else {
            $message = 'Member Rejection cancelled successfully';
        }

        return response()->json(['success' => true, 'message' => $message]);
    }
}

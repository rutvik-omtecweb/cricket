<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Event;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\EventPayment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.event.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.event.upsert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'title' => 'required|unique:events,title,id',
            'image' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'number_of_team' => 'required',
            'team_price' => 'required',
            'participant_price' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'storage/event';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        }
        $email_notifications = $request->has('email_notifications') ? 1 : 0;
        $data['email_notifications'] = $email_notifications;
        $data['image'] = $image_name;
        $data['limit_number_of_team'] = $data['number_of_team'];

        $event = Event::create($data);
        if ($email_notifications == 1 && $event) {
            $setting = GeneralSetting::first();
            $users = User::active()->verify()->get();

            if ($setting && count($users) > 0) {
                $email_template = EmailTemplate::where('title', 'Event')->first();
                if (!empty($email_template)) {
                    $subject = $email_template['subject'];
                    foreach ($users as $user) {
                        $user_name = $user->first_name . ' ' . $user->last_name;

                        $mail_data = str_replace('[name]', $user_name, $email_template['content']);
                        $mail_data = str_replace('[Event Title]', $event->title, $mail_data);
                        $mail_data = str_replace('[Event Date]', $event->start_date, $mail_data);
                        $mail_data = str_replace('[Event Start Date]', $event->start_date, $mail_data);
                        $mail_data = str_replace('[Event End Date]', $event->end_date, $mail_data);
                        $mail_data = str_replace('[Number Of Team]', $event->number_of_team, $mail_data);
                        $mail_data = str_replace('[Team Price]', $event->team_price, $mail_data);
                        $mail_data = str_replace('[Participant Price]', $event->participant_price, $mail_data);
                        $mail_data = str_replace('[Contact Information]', $setting->email, $mail_data);
                        $mail_data = str_replace('[Company]', $setting->site_name, $mail_data);

                        $email = new SendMail($mail_data);
                        // Set the subject for the email
                        $email->subject($subject);

                        // Send the email to the current user
                        Mail::to($user->email)->send($email);
                    }
                }
            }
        }
        return redirect()->route('admin.events.index')->with('message', 'Event created successfully.');
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
        $event = Event::findOrFail($id);
        return view('admin.event.upsert', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $request->validate([
            'title' => 'required|unique:events,title,' . $id . ',id',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'number_of_team' => 'required',
            'team_price' => 'required',
            'participant_price' => 'required',
        ]);

        $event = Event::findOrFail($id);
        if ($request->hasFile('image')) {

            $pathRemove = 'storage/event/';
            $imageRemove = public_path($pathRemove . $event->getRawOriginal('image'));
            if (File::exists($imageRemove)) {
                File::delete($imageRemove);
            }

            $file = $request->file('image');
            $path = 'storage/event';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        } else {
            $old = explode('/', $request->oldimage);
            $image_name = $old[count($old) - 1];
        }
        $data['image'] = $image_name;
        $email_notifications = $request->has('email_notifications') ? 1 : 0;
        $data['email_notifications'] = $email_notifications;
        $data['limit_number_of_team'] = $data['number_of_team'];
        $event->update($data);

        if ($email_notifications == 1 && $event->wasChanged('email_notifications')) {
            $setting = GeneralSetting::first();
            $users = User::active()->verify()->get();

            if ($setting && count($users) > 0) {
                $email_template = EmailTemplate::where('title', 'Event')->first();
                if (!empty($email_template)) {
                    $subject = $email_template['subject'];
                    foreach ($users as $user) {
                        $user_name = $user->first_name . ' ' . $user->last_name;

                        $mail_data = str_replace('[name]', $user_name, $email_template['content']);
                        $mail_data = str_replace('[Event Title]', $event->title, $mail_data);
                        $mail_data = str_replace('[Event Date]', $event->start_date, $mail_data);
                        $mail_data = str_replace('[Event Start Date]', $event->start_date, $mail_data);
                        $mail_data = str_replace('[Event End Date]', $event->end_date, $mail_data);
                        $mail_data = str_replace('[Number Of Team]', $event->number_of_team, $mail_data);
                        $mail_data = str_replace('[Team Price]', $event->team_price, $mail_data);
                        $mail_data = str_replace('[Participant Price]', $event->participant_price, $mail_data);
                        $mail_data = str_replace('[Contact Information]', $setting->email, $mail_data);
                        $mail_data = str_replace('[Company]', $setting->site_name, $mail_data);

                        $email = new SendMail($mail_data);
                        $email->subject($subject);
                        Mail::to($user->email)->send($email);
                    }
                }
            }
        }

        return redirect()->route('admin.events.index')->with('message', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $path = 'storage/event/';
        $image = public_path($path . $event->getRawOriginal('image'));
        if (File::exists($image)) {
            File::delete($image);
        }

        $event->delete();
        return response()->json(['success' => true, 'message' => 'Event deleted successfully.!']);
    }

    /**
     * List Banners.
     */
    public function getEvents(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = Event::query();
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where('title', 'LIKE', '%' . $searchValue . '%')->orWhere('start_date', 'LIKE', '%' . $searchValue . '%')->orWhere('end_date', 'LIKE', '%' . $searchValue . '%')
                ->orWhere('number_of_team', 'LIKE', '%' . $searchValue . '%')->orWhere('team_price', 'LIKE', '%' . $searchValue . '%')->orWhere('participant_price', 'LIKE', '%' . $searchValue . '%');
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
     * update status.
     */
    public function toggleEvent(string $id)
    {
        $event = Event::findOrFail($id);
        $event->update([
            'is_active' => !$event->is_active,
        ]);
        return response()->json(['success' => true, 'message' => 'Event status updated successfully.']);
    }

    /**
     * Display a listing of the resource.
     */
    public function purchaseTeamView($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.event.purchase_team', compact('event'));
    }

    /**
     * Display a listing of the resource.
     */
    public function ParticipantView($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.event.Participant', compact('event'));
    }


    public function purchaseTeamList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $eventID = $request->input('event_id');

        $records = EventPayment::with('event', 'user')->where('payment_for', 'purchase_team')->where('status', 'success');
        if ($eventID) {
            $records->where('event_id', $eventID);
        }
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where(function ($query) use ($searchValue) {
                $query->where('amount', 'LIKE', '%' . $searchValue . '%')->where('created_at', 'LIKE', '%' . $searchValue . '%')->orWhereHas('event', function ($q) use ($searchValue) {
                    $q->where('title', 'LIKE', '%' . $searchValue . '%');
                })->orWhereHas('user', function ($q) use ($searchValue) {
                    $q->where('first_name', 'LIKE', '%' . $searchValue . '%')->orWhere('last_name', 'LIKE', '%' . $searchValue . '%')->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $searchValue . '%']);
                });
            });
        }

        $records = $records->latest()
            ->skip($start)
            ->take($row_per_page)
            ->get();

        foreach ($records as $rd) {
            $rd->created_at_formate = \Carbon\Carbon::parse($rd->created_at)->format('j M Y g:i A');
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $records ?? [],
        );

        return response()->json($response);
    }

    public function ParticipantList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $eventID = $request->input('event_id');

        $records = EventPayment::with('event', 'user')->where('payment_for', 'participant')->where('status', 'success');
        if ($eventID) {
            $records->where('event_id', $eventID);
        }
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where(function ($query) use ($searchValue) {
                $query->where('amount', 'LIKE', '%' . $searchValue . '%')->where('created_at', 'LIKE', '%' . $searchValue . '%')->orWhereHas('event', function ($q) use ($searchValue) {
                    $q->where('title', 'LIKE', '%' . $searchValue . '%');
                })->orWhereHas('user', function ($q) use ($searchValue) {
                    $q->where('first_name', 'LIKE', '%' . $searchValue . '%')->orWhere('last_name', 'LIKE', '%' . $searchValue . '%')->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $searchValue . '%']);
                });
            });
        }

        $records = $records->latest()
            ->skip($start)
            ->take($row_per_page)
            ->get();

        foreach ($records as $rd) {
            $rd->created_at_formate = \Carbon\Carbon::parse($rd->created_at)->format('j M Y g:i A');
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData" => $records ?? [],
        );

        return response()->json($response);
    }
}

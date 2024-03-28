<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;

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
    public function toggleNewMember(string $id)
    {
        $member = User::findOrFail($id);
        $member->update([
            'is_approve' => !$member->is_approve,
        ]);
        return response()->json(['success' => true, 'message' => 'Member status updated successfully.']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.admin_user.index');
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

    public function getAdminUser(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = User::role('admin');
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where('user_name', 'LIKE', '%' . $searchValue . '%')
            ->orWhere('first_name', 'LIKE', '%' . $searchValue . '%')
            ->orWhere('last_name', 'LIKE', '%' . $searchValue . '%')
            ->orWhere('email', 'LIKE', '%' . $searchValue . '%')
            ->orWhere('phone', 'LIKE', '%' . $searchValue . '%');
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

}

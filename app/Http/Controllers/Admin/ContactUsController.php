<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('admin.contact_us.index');
    }

    /**
     * List ContactUs.
     */
    public function getContactUs(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = ContactUs::query();
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where('full_name', 'LIKE', '%' . $searchValue . '%')->orWhere('email', 'LIKE', '%' . $searchValue . '%')->orWhere('subject', 'LIKE', '%' . $searchValue . '%')
                ->orWhere('message', 'LIKE', '%' . $searchValue . '%');
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
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, $id)
    {
        $contact_us = ContactUs::findOrFail($id);
        $contact_us->delete();
        return response()->json(['success' => true, 'message' => 'Contact us deleted successfully.!']);
    }
}

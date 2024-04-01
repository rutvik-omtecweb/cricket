<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.player.index');
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
     * List Player.
     */
    public function getPlayers(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = Player::with('user')->where('status', 'success');
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where(function ($query) use ($searchValue) {
                $query->where('amount', 'LIKE', '%' . $searchValue . '%')
                    ->orWhereHas('user', function ($query) use ($searchValue) {
                        $query->where('first_name', 'LIKE', '%' . $searchValue . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $searchValue . '%')
                            ->orWhere('email', 'LIKE', '%' . $searchValue . '%')
                            ->orWhere('phone', 'LIKE', '%' . $searchValue . '%')
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $searchValue . '%']);
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
}

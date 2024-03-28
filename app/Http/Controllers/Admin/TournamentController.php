<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.tournament.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tournament.upsert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            // 'title' => 'required|unique:tournaments,title,id',
            'title' => 'required|unique:tournaments,title,NULL,id,type,0',
            // 'title' => [
            //     'required',
            //     Rule::unique('tournaments')->where(function ($query) use ($request) {
            //         return $query->where('type', $request->type);
            //     })->ignore($request->id),
            // ],
            'image' => 'required',
        ]);

        $data['type'] = 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'storage/tournament';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        }

        $data['image'] = $image_name;

        Tournament::create($data);
        return redirect()->route('admin.tournaments.index')->with('message', 'Tournament created successfully.');
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
        $tournament = Tournament::findOrFail($id);
        return view('admin.tournament.upsert', compact('tournament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $request->validate([
            // 'title' => 'required|unique:tournaments,title,' . $id . ',id',
            // 'title' => [
            //     'required',
            //     Rule::unique('tournaments')->where(function ($query) use ($request) {
            //         return $query->where('type', $request->type);
            //     })->ignore($id),
            // ],
            'title' => 'required|unique:tournaments,title,' . $id . ',id,type,' . 0,
        ]);

        $tournament = Tournament::findOrFail($id);
        $data['type'] = 0;
        if ($request->hasFile('image')) {

            $pathRemove = 'storage/tournament/';
            $imageRemove = public_path($pathRemove . $tournament->getRawOriginal('image'));
            if (File::exists($imageRemove)) {
                File::delete($imageRemove);
            }

            $file = $request->file('image');
            $path = 'storage/tournament';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        } else {
            $old = explode('/', $request->oldimage);
            $image_name = $old[count($old) - 1];
        }
        $data['image'] = $image_name;
        $tournament->update($data);

        return redirect()->route('admin.tournaments.index')->with('message', 'Tournament updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tournament = Tournament::findOrFail($id);
        $path = 'storage/tournament/';
        $image = public_path($path . $tournament->getRawOriginal('image'));
        if (File::exists($image)) {
            File::delete($image);
        }

        $tournament->delete();
        return response()->json(['success' => true, 'message' => 'Tournament deleted successfully.!']);
    }

    /**
     * List Banners.
     */
    public function getTournaments(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = Tournament::where('type', false);
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where(function ($query) use ($searchValue) {
                $query->where('title', 'LIKE', '%' . $searchValue . '%')->orWhere('description', 'LIKE', '%' . $searchValue . '%');
            });
        }

        $records = $records->latest()->where('type', false)->orderBy('created_at', 'desc')
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
    public function toggleTournament(string $id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->update([
            'is_active' => !$tournament->is_active,
        ]);
        return response()->json(['success' => true, 'message' => 'Tournament status updated successfully.']);
    }
}

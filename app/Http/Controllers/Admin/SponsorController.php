<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sponsors;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sponsor.index');
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
        $data = $request->all();

        $request->validate([
            'title' => 'required|unique:sponsors,title,id',
            'order' => [
                'required',
                Rule::unique('sponsors')->where(function ($query) use ($request) {
                    return $query->where('order', $request->order);
                }),
            ],
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'storage/sponsor';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        }

        $data['image'] = $image_name;

        Sponsors::create($data);
        return response()->json(['success' => true, 'message' => 'Sponsors successfully created.']);
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
        $sponsor = Sponsors::findOrFail($id);
        return response($sponsor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateSponsor(Request $request,  $id)
    {
        $data = $request->all();
        $request->validate([
            'title' => 'required|unique:sponsors,title,' . $id . ',id',
            'order' => [
                'required',
                Rule::unique('sponsors')->ignore($id),
            ],
        ]);

        $sponsor = Sponsors::findOrFail($id);
        if ($request->hasFile('image')) {

            $pathRemove = 'storage/sponsor/';
            $imageRemove = public_path($pathRemove . $sponsor->getRawOriginal('image'));
            if (File::exists($imageRemove)) {
                File::delete($imageRemove);
            }

            $file = $request->file('image');
            $path = 'storage/sponsor';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        } else {
            $old = explode('/', $request->old_image);
            $image_name = $old[count($old) - 1];
        }
        $data['image'] = $image_name;
        $sponsor->update($data);

        return response()->json(['success' => true, 'message' => 'Sponsors successfully updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sponsor = Sponsors::findOrFail($id);
        $path = 'storage/sponsor/';
        $image = public_path($path . $sponsor->getRawOriginal('image'));
        if (File::exists($image)) {
            File::delete($image);
        }

        $sponsor->delete();
        return response()->json(['success' => true, 'message' => 'Sponsors deleted successfully.!']);
    }

    /**
     * List Sponsors.
     */
    public function getSponsors(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = Sponsors::query();
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where('title', 'LIKE', '%' . $searchValue . '%')->orWhere('order', 'LIKE', '%' . $searchValue . '%');
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
    public function toggleSponsors(string $id)
    {
        $sponsors = Sponsors::findOrFail($id);
        $sponsors->update([
            'is_active' => !$sponsors->is_active,
        ]);
        return response()->json(['success' => true, 'message' => 'Sponsors status updated successfully.']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.photo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.photo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            // 'title' => 'required|unique:tournaments,title,NULL,id,type,1',
            'title' => 'required',

            // 'title' => [
            //     'required',
            //     Rule::unique('tournaments')->where(function ($query) use ($request) {
            //         return $query->where('type', $request->type);
            //     })->ignore($request->id),
            // ],
            'image.*' => 'required|image|max:2048'
        ]);

        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $path = 'storage/tournament';
        //     $image_name = time() . $file->getClientOriginalName();
        //     $file->move(public_path($path), $image_name);
        // }
        $images = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $image_name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/tournament'), $image_name);
                $images[] = $image_name; // Store image names in an array
            }
        }

        $data = $request->except('image'); // Exclude images from the data array
        $data['type'] = 1;
        foreach ($images as $image) {
            $data['image'] = $image;
            Tournament::create($data);
        }

        // Tournament::create($data);
        return redirect()->route('admin.photos.index')->with('message', 'Photo created successfully.');
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
        $photo = Tournament::findOrFail($id);
        return view('admin.photo.upsert', compact('photo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $request->validate([
            // 'title' => 'required|unique:tournaments,title,' . $id . ',id,type,' . 1,
            'title' => 'required',
        ]);

        $tournament = Tournament::findOrFail($id);
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

        return redirect()->route('admin.photos.index')->with('message', 'Photo updated successfully.');
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
        return response()->json(['success' => true, 'message' => 'Photo deleted successfully.!']);
    }

    /**
     * List Banners.
     */
    public function getPhotos(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = Tournament::where('type', true);
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where(function ($query) use ($searchValue) {
                $query->where('title', 'LIKE', '%' . $searchValue . '%')->orWhere('description', 'LIKE', '%' . $searchValue . '%');
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
     * update status.
     */
    public function togglePhotos(string $id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->update([
            'is_active' => !$tournament->is_active,
        ]);
        return response()->json(['success' => true, 'message' => 'Photo status updated successfully.']);
    }
}

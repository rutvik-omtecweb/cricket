<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\HomepageContent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class HomePageContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $home_page_content = HomepageContent::first();
        return view('admin.home_page_content.index', compact('home_page_content'));
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

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'storage/home_content';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        }

        $data['image'] = $image_name;

        HomepageContent::create($data);
        return redirect()->route('admin.home-content.index')->with('message', 'Home Page content has been successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $home_page_content = HomepageContent::findOrFail($id);
        return response($home_page_content);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $home = HomepageContent::findOrFail($id);
        if ($request->hasFile('image')) {

            $pathRemove = 'storage/home_content/';
            $imageRemove = public_path($pathRemove . $home->getRawOriginal('image'));
            if (File::exists($imageRemove)) {
                File::delete($imageRemove);
            }

            $file = $request->file('image');
            $path = 'storage/home_content';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        } else {
            $old = explode('/', $request->old_image);
            $image_name = $old[count($old) - 1];
        }
        $data['image'] = $image_name;
        $home->update($data);

        return redirect()->route('admin.home-content.index')->with('message', 'Home Page content has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // HomepageContent::find($id)->delete();
        // return response()->json(['success' => true, 'message' => 'Home Page content deleted successfully.!']);
    }

    /**
     * List Banners.
     */
    public function getHomePageContent(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = HomepageContent::query();
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->orWhere('description', 'LIKE', '%' . $searchValue . '%');
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
    // public function toggleHomePageContent(string $id)
    // {
    //     $home = HomepageContent::findOrFail($id);
    //     $home->update([
    //         'is_active' => !$home->is_active,
    //     ]);
    //     return response()->json(['success' => true, 'message' => 'Home Page content status updated successfully.']);
    // }
}

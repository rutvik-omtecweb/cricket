<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner.upsert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'title' => 'required|unique:banners,title,id',
            'image' => 'required',
            'order' => [
                'required',
                Rule::unique('banners')->where(function ($query) use ($request) {
                    return $query->where('order', $request->order);
                }),
            ],
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'storage/banner';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        }

        $data['image'] = $image_name;

        Banner::create($data);
        return redirect()->route('admin.banners.index')->with('message', 'Banner created successfully.');
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
        $banner = Banner::findOrFail($id);
        return view('admin.banner.upsert', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $request->validate([
            'title' => 'required|unique:banners,title,' . $id . ',id',
            'order' => [
                'required',
                Rule::unique('banners')->ignore($id),
            ],
        ]);

        $banner = Banner::findOrFail($id);
        if ($request->hasFile('image')) {

            $pathRemove = 'storage/banner/';
            $imageRemove = public_path($pathRemove . $banner->getRawOriginal('image'));
            if (File::exists($imageRemove)) {
                File::delete($imageRemove);
            }

            $file = $request->file('image');
            $path = 'storage/banner';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        } else {
            $old = explode('/', $request->oldimage);
            $image_name = $old[count($old) - 1];
        }
        $data['image'] = $image_name;
        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('message', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        $path = 'storage/banner/';
        $image = public_path($path . $banner->getRawOriginal('image'));
        if (File::exists($image)) {
            File::delete($image);
        }

        $banner->delete();
        return response()->json(['success' => true, 'message' => 'Banner deleted successfully.!']);
    }

    /**
     * List Banners.
     */
    public function getBanner(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = Banner::query();
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where('title', 'LIKE', '%' . $searchValue . '%')->orWhere('order', 'LIKE', '%' . $searchValue . '%')->orWhere('description', 'LIKE', '%' . $searchValue . '%');
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
    public function toggleBanner(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update([
            'is_active' => !$banner->is_active,
        ]);
        return response()->json(['success' => true, 'message' => 'Banner status updated successfully.']);
    }
}

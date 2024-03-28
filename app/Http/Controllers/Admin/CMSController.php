<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Str;

class CMSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.cms.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cms.upsert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cms_page_name' => 'required|unique:cms_pages,cms_page_name,id',
            'body' => 'required',
            'url' => 'required',
        ]);
        $data = $request->all();
        $data['slug'] = Str::slug($data['cms_page_name']);
        $cms = CmsPage::create($data);
        return redirect()->route('admin.cms.index')->with('message', 'Cms page created successfully.');
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
        $cms_page = CmsPage::findOrFail($id);
        return view('admin.cms.upsert', compact('cms_page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'cms_page_name' => 'required|unique:cms_pages,cms_page_name,' . $id . ',id',
        ]);
        $data = $request->all();
        $cms = CmsPage::findOrFail($id);
        $cms->update($data);
        return redirect()->route('admin.cms.index')->with('message', 'Cms page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cms = CmsPage::findOrFail($id);
        $cms->delete();
        return response()->json(['success' => true, 'message' => 'Cms page deleted successfully.!']);
    }

    /**
     * List CMS.
     */
    public function getCMS(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = CmsPage::query();
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where('url', 'LIKE', '%' . $searchValue . '%')->orWhere('cms_page_name', 'LIKE', '%' . $searchValue . '%')->orWhere('body', 'LIKE', '%' . $searchValue . '%');
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
    public function toggleCMS(string $id)
    {
        $cms = CmsPage::findOrFail($id);
        $cms->update([
            'is_active' => !$cms->is_active,
        ]);
        return response()->json(['success' => true, 'message' => 'Cms page status updated successfully.']);
    }
}

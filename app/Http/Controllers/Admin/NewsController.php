<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OuterNews;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outer_news = OuterNews::first();
        return view('admin.news.index', compact('outer_news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.upsert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'news_name' => 'required|unique:news,news_name,id',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'storage/news';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        }

        $data['image'] = $image_name;

        News::create($data);
        // return response()->json(['success' => true, 'message' => 'News has been successfully created.']);
        return redirect()->route('admin.news.index')->with('message', 'News has been successfully created.');
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
        $news = News::findOrFail($id);
        // return response($news);
        return view('admin.news.upsert', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $news = News::findOrFail($id);
        $request->validate([
            'news_name' => 'required|unique:news,news_name,' . $id . ',id',
        ]);
        if ($request->hasFile('image')) {

            $pathRemove = 'storage/news/';
            $imageRemove = public_path($pathRemove . $news->getRawOriginal('image'));
            if (File::exists($imageRemove)) {
                File::delete($imageRemove);
            }

            $file = $request->file('image');
            $path = 'storage/news';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        } else {
            $old = explode('/', $request->oldimage);
            $image_name = $old[count($old) - 1];
        }
        $data['image'] = $image_name;
        $news->update($data);

        return redirect()->route('admin.news.index')->with('message', 'News has been successfully updated.');
    }

    // public function updateNews(Request $request, string $id)
    // {
    //     $data = $request->all();
    //     $news = News::findOrFail($id);
    //     $request->validate([
    //         'news_name' => 'required|unique:news,news_name,' . $id . ',id',
    //     ]);
    //     if ($request->hasFile('image')) {

    //         $pathRemove = 'storage/news/';
    //         $imageRemove = public_path($pathRemove . $news->getRawOriginal('image'));
    //         if (File::exists($imageRemove)) {
    //             File::delete($imageRemove);
    //         }

    //         $file = $request->file('image');
    //         $path = 'storage/news';
    //         $image_name = time() . $file->getClientOriginalName();
    //         $file->move(public_path($path), $image_name);
    //     } else {
    //         $old = explode('/', $request->old_image);
    //         $image_name = $old[count($old) - 1];
    //     }
    //     $data['image'] = $image_name;
    //     $news->update($data);

    //     return response()->json(['success' => true, 'message' => 'News has been successfully updated.']);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);
        $path = 'storage/news/';
        $image = public_path($path . $news->getRawOriginal('image'));
        if (File::exists($image)) {
            File::delete($image);
        }
        $news->delete();
        return response()->json(['success' => true, 'message' => 'News deleted successfully.!']);
    }

    /**
     * List News.
     */
    public function getNews(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = News::query();
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where('news_name', 'LIKE', '%' . $searchValue . '%')->orWhere('description', 'LIKE', '%' . $searchValue . '%');
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
    public function toggleNews(string $id)
    {
        $news = News::findOrFail($id);
        $news->update([
            'is_active' => !$news->is_active,
        ]);
        return response()->json(['success' => true, 'message' => 'News status updated successfully.']);
    }

    public function updateOuterNews(Request $request)
    {
        $data = $request->all();
        if ($data['outer_new_id']) {
            $outer_news = OuterNews::findOrFail($data['outer_new_id']);
            $outer_news->update(
                [
                    'link' => $data['link'],
                    'limit' => $data['limit']
                ]

            );
        } else {
            OuterNews::create([
                'link' => $data['link'],
                'limit' => $data['limit']
            ]);
        }
        return redirect()->route('admin.news.index')->with('message', 'Outer News has been successfully updated.');
    }
}

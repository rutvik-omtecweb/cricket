<?php

namespace App\Http\Controllers;

use App\Models\LiveScore;
use Illuminate\Http\Request;

class LiveScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $live_score = LiveScore::first();
        return view('admin.live_score.index', compact('live_score'));
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
        LiveScore::create($data);
        return redirect()->route('admin.live-score.index')->with('message', 'Live Score has been successfully created.');
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
        $data = $request->all();
        $live_score = LiveScore::findOrFail($id);
        $live_score->update($data);

        return redirect()->route('admin.live-score.index')->with('message', 'Live Score has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class AboutUsController extends Controller
{
    public function index()
    {
        $about_us = AboutUs::first();
        return view('admin.about_us.index', compact('about_us'));
    }

    public function storeAboutUS(Request $request)
    {
        $data = $request->all();
        if ($data['id'] == null) {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = 'storage/about_us';
                $image_name = time() . $file->getClientOriginalName();
                $file->move(public_path($path), $image_name);
            }
            $data['image'] = $image_name;
            AboutUs::create($data);
        } else {

            $about_us = AboutUs::findOrFail($data['id']);
            if ($request->hasFile('image')) {

                $pathRemove = 'storage/about_us/';
                $imageRemove = public_path($pathRemove . $about_us->getRawOriginal('image'));
                if (File::exists($imageRemove)) {
                    File::delete($imageRemove);
                }

                $file = $request->file('image');
                $path = 'storage/about_us';
                $image_name = time() . $file->getClientOriginalName();
                $file->move(public_path($path), $image_name);
            } else {
                $old = explode('/', $request->oldimage);
                $image_name = $old[count($old) - 1];
            }
            $data['image'] = $image_name;
            $about_us->update($data);
        }
        return redirect()->route('admin.about.us')->with('message', 'About Us information has been successfully updated.');
    }
}

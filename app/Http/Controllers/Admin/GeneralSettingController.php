<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $general_setting = GeneralSetting::first();
        return view('admin.general_setting.index', compact('general_setting'));
    }

    public function settingUpdate(Request $request, string $id)
    {
        $data = $request->all();
        $data['health_card_document'] = $request->has('health_card_document') ? 1 : 0;
        $data['licence_document'] = $request->has('licence_document') ? 1 : 0;
        $data['other_document'] = $request->has('other_document') ? 1 : 0;
        if ($data['id'] == null) {
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $path = 'storage/setting';
                $image_name = time() . $file->getClientOriginalName();
                $file->move(public_path($path), $image_name);
                $data['logo'] = $image_name;
            }

            if ($request->hasFile('favicon')) {
                $fileFav = $request->file('favicon');
                $path = 'storage/setting';
                $image_name_fav = time() . $fileFav->getClientOriginalName();
                $fileFav->move(public_path($path), $image_name_fav);
                $data['favicon'] = $image_name_fav;
            }

            GeneralSetting::create($data);
        } else {
            $setting = GeneralSetting::findOrFail($data['id']);
            $pathRemove = 'storage/setting/';

            if ($request->hasFile('logo')) {

                if (!empty($setting)) {
                    $imageRemove = public_path($pathRemove . $setting->getRawOriginal('logo'));
                    if (File::exists($imageRemove)) {
                        File::delete($imageRemove);
                    }
                }

                $file = $request->file('logo');
                $path = 'storage/setting';
                $image_name = time() . $file->getClientOriginalName();
                $file->move(public_path($path), $image_name);
                $data['logo'] = $image_name;
            }

            if ($request->hasFile('favicon')) {
                if (!empty($setting)) {

                    $imageRemoveFav = public_path($pathRemove . $setting->getRawOriginal('favicon'));
                    if (File::exists($imageRemoveFav)) {
                        File::delete($imageRemoveFav);
                    }
                }

                $file = $request->file('favicon');
                $path = 'storage/setting';
                $image_name1 = time() . $file->getClientOriginalName();
                $file->move(public_path($path), $image_name1);
                $data['favicon'] = $image_name1;
            }
            $setting->update($data);
        }
        return redirect()->route('admin.general.setting')->with('message', 'General Setting updated successfully.');
    }
}

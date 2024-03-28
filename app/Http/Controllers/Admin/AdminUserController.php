<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.admin_user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin_user.upsert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'user_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|numeric|digits:10|unique:users',
            'password' => 'required',
            'image' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'storage/user/';
            $image_name = 'image' . time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        }

        $data['image'] = $image_name;
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        $user->assignRole('admin');
        return redirect()->route('admin.admin-user.index')->with('message', 'Admin-user created successfully.');
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
        $user = User::findOrFail($id);
        return view('admin.admin_user.upsert', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $request->validate([
            'user_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|numeric|digits:10|unique:users,phone,' . $id . ',id',
        ]);

        $path = 'storage/user';
        $user = User::findOrFail($id);

        if ($request->hasFile('image')) {

            $pathRemove = 'storage/user/';
            $imageRemove = public_path($pathRemove . $user->getRawOriginal('image'));
            if (File::exists($imageRemove)) {
                File::delete($imageRemove);
            }

            $file = $request->file('image');
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        } else {
            $old = explode('/', $request->oldimage);
            $image_name = $old[count($old) - 1];
        }
        $data['image'] = $image_name;

        $user->update($data);
        return redirect()->route('admin.admin-user.index')->with('message', 'Admin-user has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $path = 'storage/user/';
        $image = public_path($path . $user->getRawOriginal('image'));
        if (File::exists($image)) {
            File::delete($image);
        }

        $user->delete();
        return response()->json(['success' => true, 'message' => 'Admin-user deleted successfully.!']);
    }

    public function getAdminUser(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = User::role('admin');
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where('user_name', 'LIKE', '%' . $searchValue . '%')
            ->orWhere('first_name', 'LIKE', '%' . $searchValue . '%')
            ->orWhere('last_name', 'LIKE', '%' . $searchValue . '%')
            ->orWhere('email', 'LIKE', '%' . $searchValue . '%')
            ->orWhere('phone', 'LIKE', '%' . $searchValue . '%');
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

    public function toggleAdminUser(string $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'is_active' => !$user->is_active,
        ]);
        return response()->json(['success' => true, 'message' => 'Admin-user status updated successfully.']);
    }

}

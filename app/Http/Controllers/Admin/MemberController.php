<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Imports\MemberImport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\File;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.member.index');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('payment_collect')->findOrFail($id);
        $player = Player::where('user_id', $id)->where('status', 'success')->first();
        $setting = GeneralSetting::first();
        return view('admin.member.view', compact('user', 'player', "setting"));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $hasAssociatedTeam = $user->team_member()->exists();

            if ($hasAssociatedTeam) {
                return response()->json(['success' => false, 'message' => 'Cannot delete member with associated team.']);
            }
            $path = 'storage/user/';
            $image = public_path($path . $user->getRawOriginal('image'));
            if (File::exists($image)) {
                File::delete($image);
            }
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Member deleted successfully.!']);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Member not found!',
            ]);
        }

        // $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully.!']);
    }

    /**
     * List Members.
     */
    public function getMember(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];

        $records = User::role('member')->with('roles', 'payment_collect')->verify()->approve();
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records;
            $records = $records->where(function ($query) use ($searchValue) {
                $query->where('user_name', 'LIKE', '%' . $searchValue . '%')->orWhere('first_name', 'LIKE', '%' . $searchValue . '%')->orWhere('last_name', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchValue . '%')->orWhere('phone', 'LIKE', '%' . $searchValue . '%')->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $searchValue . '%'])
                    ->orWhereHas('payment_collect', function ($q) use ($searchValue) {
                        $q->where('amount', 'LIKE', '%' . $searchValue . '%');
                    });
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
    public function toggleMember(string $id)
    {
        $member = User::findOrFail($id);
        $member->update([
            'is_active' => !$member->is_active,
        ]);
        return response()->json(['success' => true, 'message' => 'Member status updated successfully.']);
    }

    /**
     * import member.
     */
    public function import(Request $request)
    {
        try {
            $import = new MemberImport();
            $import->import($request->file('import_file'));
            $failures = $import->failures();
            if (count($failures) > 0) {
                $errors = array();
                foreach ($failures as $failure) {
                    $old = $errors[$failure->row()]['errors'] ?? [];
                    $errors[$failure->row()]['line'] = $failure->row();
                    $errors[$failure->row()]['errors'] = array_merge($old, $failure->errors());
                }
                $xdata = array();
                foreach ($errors as $error) {
                    array_push($xdata, $error);
                }
                return response()->json(['success' => false, 'message' => 'Import has errors', 'errors' => $xdata], 500);
            }
            return response()->json(['success' => true, 'message' => 'Members imported successfully.']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['success' => false, 'message' => $exception->getMessage()]);
        }
    }
}

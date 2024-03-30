<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\User;
use App\Models\Player;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.teams.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = User::role('member')->with('roles')->active()->verify()->approve()->get();
        return view('admin.teams.upsert', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'team_name' => 'required|unique:teams,team_name,id',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'storage/teams';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        }

        $data['image'] = $image_name;
        $team = Team::create($data);

        if (isset($request->member_id)) {
            foreach ($request->member_id as $key => $member) {
                TeamMember::create([
                    'team_id' => $team->id,
                    'member_id' => $member
                ]);
            }
        }
        return redirect()->route('admin.teams.index')->with('message', 'Team has been successfully created.');
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
        $teams = Team::with('team_member.player')->findOrFail($id);
        // $members = User::role('member')->with('roles')->active()->verify()->approve()->get();
        $members = Player::with('user')->where('status', 'success')->get();
        $selected_member = TeamMember::with('player')->where('team_id', $id)->get();
        return view('admin.teams.upsert', compact('teams', 'members', 'selected_member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $team = Team::findOrFail($id);
        $request->validate([
            'team_name' => 'required|unique:teams,team_name,' . $id . ',id',
        ]);
        if ($request->hasFile('image')) {

            $pathRemove = 'storage/teams/';
            $imageRemove = public_path($pathRemove . $team->getRawOriginal('image'));
            if (File::exists($imageRemove)) {
                File::delete($imageRemove);
            }

            $file = $request->file('image');
            $path = 'storage/teams';
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $image_name);
        } else {
            $old = explode('/', $request->oldimage);
            $image_name = $old[count($old) - 1];
        }
        $data['image'] = $image_name;

        $data['member_id'] = isset($request->member_id) ? implode(", ", @$request->member_id) : null;
        $team->update($data);

        if (isset($request->member_id)) {
            foreach ($request->member_id as $key => $member) {

                TeamMember::updateOrCreate(
                    [
                        'team_id' => $team->id,
                        'member_id' => $member
                    ],
                );
            }

            TeamMember::where('team_id', $team->id)
                ->whereNotIn('member_id', $request->member_id)
                ->delete();
        } else {
            TeamMember::where('team_id', $team->id)
                ->delete();
        }

        return redirect()->route('admin.teams.index')->with('message', 'Team has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $team = Team::findOrFail($id);
        $path = 'storage/teams/';
        $image = public_path($path . $team->getRawOriginal('image'));
        if (File::exists($image)) {
            File::delete($image);
        }
        TeamMember::where('team_id', $id)->delete();
        $team->delete();
        return response()->json(['success' => true, 'message' => 'Team deleted successfully.!']);
    }

    /**
     * List News.
     */
    public function getTeams(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $row_per_page = $request->get("length");
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $records = Team::with('user')->with('team_member.player.user')->withCount('team_member');
        $totalRecords = $records->count();

        $totalRecordsWithFilter = $records->count();

        if ($searchValue) {
            $records = $records->where(function ($query) use ($searchValue) {
                $query->where('team_name', 'LIKE', '%' . $searchValue . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchValue . '%')
                    ->orWhereHas('team_member', function ($subQuery) use ($searchValue) {
                        $subQuery->select('team_id')->groupBy('team_id')->havingRaw('COUNT(*) = ?', [$searchValue]);
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
    public function toggleTeam(string $id)
    {
        $teams = Team::findOrFail($id);
        $teams->update([
            'is_active' => !$teams->is_active,
        ]);
        return response()->json(['success' => true, 'message' => 'Teams status updated successfully.']);
    }
}

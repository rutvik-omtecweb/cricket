<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\EventPayment;
use App\Models\Player;

class DashboardController extends Controller
{
    public function index()
    {
        $teams = Team::active()->count();
        $members = User::role('member')->with('roles')->active()->verify()->approve()->count();
        $players = Player::where('status', 'success')->count();
        $startOfWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfWeek = Carbon::now()->subWeek()->endOfWeek();
        $membersLastWeek = User::role('member')
            ->with('roles', 'payment_collect')
            ->active()
            ->verify()
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();
        $totalRegistrationsLastWeek = $membersLastWeek->count();
        $approve_member = User::role('member')->with('roles', 'payment_collect')->active()->verify()->approve()->get();
        return view('admin.dashboard.index', compact('teams', 'members', 'players', 'totalRegistrationsLastWeek', 'approve_member', 'membersLastWeek', 'players'));
    }
}

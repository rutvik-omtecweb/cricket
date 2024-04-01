<?php

namespace App\Exports;

use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeamExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Team::with(['user', 'team_member'])->latest()->get()->map(function ($team) {
            // Prepare data for export
            return [
                'TeamName' => $team->team_name,
                'Captain Name' => $team->user->first_name . ' ' . $team->user->last_name ?? '',
                'Captain Email' => $team->user->email ?? '',
                'Number of Members' => $team->team_member->count(), // Count the number of members
                'Status' => $team->is_active == 1 ? 'active' : 'inactive',
            ];
        });
    }

    public function headings(): array
    {
        return ["TeamName", "Captain Name", "Captain Email", "Number of Members", "Status"];
    }
}

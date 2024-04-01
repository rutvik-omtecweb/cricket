<?php

namespace App\Exports;

use App\Models\Team;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::role('member')->with('roles', 'payment_collect')->verify()->approve()->latest()->get()->map(function ($user) {
            // Prepare data for export
            return [
                'User Name' => $user->user_name,
                'Name' => $user->first_name . ' ' . $user->last_name ?? '',
                'Email' => $user->email ?? '',
                'Phone' => $user->phone ?? '',
                'Paid Amount' => $user->payment_collect->amount,
                'Expired Date' => $user->payment_collect->expired_date,
                'Status' => $user->is_active == 1 ? 'active' : 'inactive',
            ];
        });
    }

    public function headings(): array
    {
        return ["User Name", "Name", "Email", "Phone", "Paid Amount", "Expired Date", "Status"];
    }
}

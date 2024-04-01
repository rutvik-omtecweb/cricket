<?php

namespace App\Exports;

use App\Models\Player;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlayerExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Player::with(['user'])->latest()->get()->map(function ($player) {
            // Prepare data for export
            return [
                'Name' => $player->user->first_name . ' ' . $player->user->last_name ?? '',
                'Email' => $player->user->email ?? '',
                'Phone' => $player->user->phone ?? '',
                'Amount' => $player->amount, // Count the number of members,
                "Payment Type" => $player->payment_type,
            ];
        });
    }

    public function headings(): array
    {
        return ["Name", "Email", "Phone", "Amount", "Payment Type"];
    }
}

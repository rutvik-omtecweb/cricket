<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::create([
            'title' => 'Member Registration Fees',
            'amount' => '9',
            'days' => '365',
        ]);

        Payment::create([
            'title' => 'Player Fees',
            'amount' => '25',
        ]);
    }
}

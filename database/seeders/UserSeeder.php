<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'user_name' => 'admin',
            'first_name' => 'admin',
            'last_name' => 'test',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123'),
            'phone' => '1234567890',
            'is_active' => true
        ]);


    }
}

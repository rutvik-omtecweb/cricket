<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'team_name' => 'BISONS CRICKET CLUB',
            'image' => 'team1.jpg',
            'is_active' => true,
        ]);
        Team::create([
            'team_name' => 'FORT MCMURRAY TITANS',
            'image' => 'team2.png',
            'is_active' => true,
        ]);
        Team::create([
            'team_name' => 'JAMAICA CRICKET CLUB',
            'image' => 'team3.jpg',
            'is_active' => true,
        ]);
        Team::create([
            'team_name' => 'KINGS XI',
            'image' => 'team4.png',
            'is_active' => true,
        ]);
        Team::create([
            'team_name' => 'MCC WOLVES',
            'image' => 'team5.jpg',
            'is_active' => true,
        ]);
        Team::create([
            'team_name' => 'ROYAL STRIKERS CRICKET CLUB',
            'image' => 'team6.png',
            'is_active' => true,
        ]);
        Team::create([
            'team_name' => 'SNYEPERS CRICKET CLUB',
            'image' => 'team7.jpg',
            'is_active' => true,
        ]);
        Team::create([
            'team_name' => 'STRIKE FORCE CRICKET CLUB',
            'image' => 'team8.jpg',
            'is_active' => true,
        ]);
        Team::create([
            'team_name' => 'VIKINGS',
            'image' => 'team9.jpg',
            'is_active' => true,
        ]);
    }
}

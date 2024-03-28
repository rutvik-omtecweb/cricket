<?php

namespace Database\Seeders;

use App\Models\OuterNews;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OuterNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OuterNews::create([
            'link' => 'https://www.espn.com/espn/rss/news',
            'limit' => '4',
        ]);
    }
}

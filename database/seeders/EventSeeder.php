<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'title' => "Holi Event",
            'description' => 'Some dummy description about this card you do not need to read.',
            'image' => "event.jpg",
            'start_date' => "2024-03-18",
            'end_date' => "2024-05-25",
            'number_of_team' => "15",
            'team_price' => "20",
            'participant_price' => "15",
            'limit_number_of_team' => "15",
            'email_notifications' => true,
            'is_active' => true,
            'location' => "location"
        ]);

        Event::create([
            'title' => "Diwali Event",
            'description' => 'Some dummy description about this card you do not need to read.',
            'image' => "event1.jpg",
            'start_date' => "2024-03-18",
            'end_date' => "2024-05-25",
            'number_of_team' => "15",
            'team_price' => "20",
            'participant_price' => "15",
            'limit_number_of_team' => "15",
            'email_notifications' => true,
            'is_active' => true,
            'location' => "location"
        ]);
    }
}

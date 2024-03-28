<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralSetting::create([
            'site_name' => 'Northern Alberta Cricket Association & Cricket Fort McMurray',
            'email' => 'cricketfortmcmurray@gmail.com',
            'phone' => '(780) 972-2555',
            'address' => '1-220 swanson crescent, Fort Mcmurray, Alberta',
            'maintenance' => false,
            'company_email' => 'cricketfortmcmurray@gmail.com',
        ]);
    }
}

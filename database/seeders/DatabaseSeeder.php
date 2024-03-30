<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PaymentConfigSeeder::class,
            EventSeeder::class,
            UserSeeder::class,
            RoleSeeder::class,
            MenuSeeder::class,
            EmailTemplateSeeder::class,
            GeneralSettingSeeder::class,
            CmsPagesSeeder::class,
            HomeSeeder::class,
            // TeamSeeder::class,
            OuterNewsSeeder::class
        ]);
    }
}

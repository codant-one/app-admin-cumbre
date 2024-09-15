<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,

            CategoryTypeSeeder::class,
            CategorySeeder::class,

            SponsorSeeder::class,
            PlaceSeeder::class,
            NewSeeder::class,

            PositionSeeder::class,
            SocialNetworkSeeder::class,
            ScheduleSeeder::class,
            TalkSeeder::class,
            SpeakerSeeder::class
        ]);
    }
}

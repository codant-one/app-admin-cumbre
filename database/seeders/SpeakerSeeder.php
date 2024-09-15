<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\Models\Speaker;
use App\Models\SocialLink;
use App\Models\Talk;
use App\Models\TalkSpeaker;

class SpeakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public/speakers');

        if (!file_exists(storage_path('app/public/speakers'))) {
            mkdir(storage_path('app/public/speakers'), 0755,true);
        } //create a folder

        $faker = Faker::create();
        $speakers = Speaker::factory(20)->create();

        foreach($speakers as $speaker) {
            for($i = 1; $i <= rand(1, 3); $i++) {
                SocialLink::insert([
                    'speaker_id' => $speaker->id,
                    'social_network_id' => $i,
                    'link' => $faker->url,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        $talks = Talk::all();

        foreach($talks as $talk) {
            for($i = 1; $i <= rand(1, 10); $i++) {
                TalkSpeaker::insert([
                    'talk_id' => $talk->id,
                    'speaker_id' => rand(1, 20),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

    }
}

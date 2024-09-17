<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\Models\Translation;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();         
    
        Translation::insert([
            'link_es' => $faker->url,
            'link_en' => $faker->url,
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}

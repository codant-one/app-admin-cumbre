<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\Models\Map;

class MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public/maps');

        if (!file_exists(storage_path('app/public/maps'))) {
            mkdir(storage_path('app/public/maps'), 0755,true);
        } //create a folder

        $faker = Faker::create();         
    
        Map::insert([
            'image' => 'maps/' . $faker->file(public_path('images/maps'), storage_path('app/public/maps'), false),
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}

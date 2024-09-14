<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\Models\Place;
use App\Models\PlaceImage;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public/places');

        if (!file_exists(storage_path('app/public/places'))) {
            mkdir(storage_path('app/public/places'), 0755,true);
        } //create a folder

        $faker = Faker::create();
        $places = Place::factory(12)->create();

        foreach($places as $place) {

            $images = [
                [
                    'place_id' => $place->id,
                    'image' => 'places/' . $faker->file(public_path('images/places/model2'), storage_path('app/public/places'), false),
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'place_id' => $place->id,
                    'image' => 'places/' . $faker->file(public_path('images/places/model3'), storage_path('app/public/places'), false),
                    'created_at' => now(),
                    'updated_at' => now()
                ]                
            ];
    
            PlaceImage::insert($images);
        }

    }
}

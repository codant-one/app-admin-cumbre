<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Seeder;

use App\Models\Talk;

class TalkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public/talks');

        if (!file_exists(storage_path('app/public/talks'))) {
            mkdir(storage_path('app/public/talks'), 0755,true);
        } //create a folder

        Talk::factory(50)->create();

    }
}

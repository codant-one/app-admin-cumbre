<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Seeder;

use App\Models\News;

class NewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public/news');

        if (!file_exists(storage_path('app/public/news'))) {
            mkdir(storage_path('app/public/news'), 0755,true);
        } //create a folder

        News::factory(12)->create();
    }
}

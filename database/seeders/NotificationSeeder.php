<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Seeder;

use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notification::factory(12)->create();
    }
}

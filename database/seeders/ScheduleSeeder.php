<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Seeder;

use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!file_exists(storage_path('app/public/schedules'))) {
            mkdir(storage_path('app/public/schedules'), 0755,true);
        } //create a folder

        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public/schedules');


        $schedules = [
            [
                'name_es' => 'Agenda Académica',
                'name_en' => 'Academic Schedule',
                'image' => 'schedules/schedule1.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name_es' => 'Agenda de Exploración',
                'name_en' => 'Exploration Schedule',
                'image' => 'schedules/schedule2.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name_es' => 'Agenda técnica de Producción',
                'name_en' => 'Technical Production Schedule',
                'image' => 'schedules/schedule3.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name_es' => 'Agenda técnica de Midstream',
                'name_en' => 'Midstream Technical Schedule',
                'image' => 'schedules/schedule4.png',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Schedule::insert($schedules);

        copy(public_path('images/schedules/model1/schedule1.png'), storage_path('app/public/schedules/schedule1.png'));
        copy(public_path('images/schedules/model2/schedule2.png'), storage_path('app/public/schedules/schedule2.png'));
        copy(public_path('images/schedules/model3/schedule3.png'), storage_path('app/public/schedules/schedule3.png'));
        copy(public_path('images/schedules/model4/schedule4.png'), storage_path('app/public/schedules/schedule4.png'));
    }
}

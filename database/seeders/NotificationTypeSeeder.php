<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\NotificationType;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notificationy_types = [
            [
                'name' => 'Agenda',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'General',
                'created_at' => now(),
                'updated_at' => now()
            ]           
        ];

        NotificationType::insert($notificationy_types);

    }
}

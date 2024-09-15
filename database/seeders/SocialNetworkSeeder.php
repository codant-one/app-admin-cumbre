<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\SocialNetwork;

class SocialNetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $social_networks = [
            [
                'name' => 'Facebook',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Instagram',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Twitter',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        SocialNetwork::insert($social_networks);

    }
}

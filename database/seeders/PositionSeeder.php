<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            [
                'name_es' => 'Director de Noticias',
                'name_en' => 'News Director',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name_es' => 'Periodista y politóloga',
                'name_en' => 'Journalist and political scientist',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name_es' => 'Director de `El Tiempo`',
                'name_en' => 'Director of `El Tiempo`',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Position::insert($positions);

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\CategoryType;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_types = [
            [
                'name_es' => 'Patrocinadores',
                'name_en' => 'Sponsors',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name_es' => 'Lugares',
                'name_en' => 'Places',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name_es' => 'Últimas actualizaciones',
                'name_en' => 'Latest Updates',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name_es' => 'Charlas',
                'name_en' => 'Talks',
                'created_at' => now(),
                'updated_at' => now()
            ]
           
        ];

        CategoryType::insert($category_types);

    }
}

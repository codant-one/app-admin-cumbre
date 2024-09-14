<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            // patrocinadores - sponsors
            [
                'category_type_id' => 1,
                'name_es' => 'Oficial',
                'name_en' => 'Official',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 1,
                'name_es' => 'Platinum',
                'name_en' => 'Platinum',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 1,
                'name_es' => 'Patrocinadores',
                'name_en' => 'Sponsors',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 1,
                'name_es' => 'Expositores',
                'name_en' => 'Exhibitors',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // lugares - places
            [
                'category_type_id' => 2,
                'name_es' => 'Lugares',
                'name_en' => 'Places',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 2,
                'name_es' => 'Restaurantes',
                'name_en' => 'Restaurants',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // noticias - news
            [
                'category_type_id' => 3,
                'name_es' => 'Petróleo',
                'name_en' => 'Oil',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 3,
                'name_es' => 'Gas',
                'name_en' => 'Gas',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 3,
                'name_es' => 'Energía',
                'name_en' => 'Energy',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // charlas - talks
            [
                'category_type_id' => 4,
                'name_es' => 'Transición energética',
                'name_en' => 'Energy transition',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 4,
                'name_es' => 'El futuro de los combustibles líquidos',
                'name_en' => 'The future of liquid fuels',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 4,
                'name_es' => 'Innovación tecnológica y transformación digital',
                'name_en' => 'Technological innovation and digital transformation',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 4,
                'name_es' => 'Regulación, política y gobernanza',
                'name_en' => 'Regulation, policy and governance',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 4,
                'name_es' => 'Mercados energéticos y dinámicas globales',
                'name_en' => 'Energy markets and global dynamics',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 4,
                'name_es' => 'Gas y seguridad energética',
                'name_en' => 'Gas and energy security',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 4,
                'name_es' => 'Desarrollo humano y capital social',
                'name_en' => 'Human development and social capital',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 4,
                'name_es' => 'Impacto social y desarrollo territorial',
                'name_en' => 'Social impact and territorial development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 4,
                'name_es' => 'Seguridad, democracia y energía',
                'name_en' => 'Security, democracy and energy',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_type_id' => 4,
                'name_es' => 'Del mar para los colombianos',
                'name_en' => 'From the sea for Colombians',
                'created_at' => now(),
                'updated_at' => now()
            ]                   
        ];

        Category::insert($categories);

    }
}

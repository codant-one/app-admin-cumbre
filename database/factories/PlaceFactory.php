<?php

namespace Database\Factories;

use Str;
use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PlaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Place::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => rand(5, 6),
            'title_es' => $this->faker->text,
            'title_en' => $this->faker->text,
            'description_es' => $this->faker->randomHtml,
            'description_en' => $this->faker->randomHtml,
            'image' => 'places/' . $this->faker->file(public_path('images/places/model1'), storage_path('app/public/places'), false),
            'link' => $this->faker->url,
            'is_popular' => rand(0,1),
            'created_at' => now(),
            'updated_at' => now()
        ];
        
    }
}

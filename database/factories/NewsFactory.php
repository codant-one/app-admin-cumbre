<?php

namespace Database\Factories;

use Str;
use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => rand(7, 9),
            'title_es' => $this->faker->text,
            'title_en' => $this->faker->text,
            'content_es' => $this->faker->randomHtml,
            'content_en' => $this->faker->randomHtml,
            'date' => now(),
            'image' => 'news/' . $this->faker->file(public_path('images/news'), storage_path('app/public/news'), false),
            'is_popular' => rand(0,1),
            'created_at' => now(),
            'updated_at' => now()
        ];
        
    }
}

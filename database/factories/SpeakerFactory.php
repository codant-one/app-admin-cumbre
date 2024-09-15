<?php

namespace Database\Factories;

use Str;
use App\Models\Speaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class SpeakerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Speaker::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'position_id' => rand(1, 3),
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'description_es' => $this->faker->text,
            'description_en' => $this->faker->text,
            'avatar' => 'speakers/' . $this->faker->file(public_path('images/speakers'), storage_path('app/public/speakers'), false),
            'is_popular' => rand(0, 1),
            'created_at' => now(),
            'updated_at' => now()
        ];
        
    }
}

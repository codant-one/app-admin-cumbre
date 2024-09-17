<?php

namespace Database\Factories;

use Str;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 3,
            'talk_id' => rand(1, 50),
            'rating' => rand(1,5),
            'comment' => $this->faker->text,
            'created_at' => now(),
            'updated_at' => now()
        ];
        
    }
}

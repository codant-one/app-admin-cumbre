<?php

namespace Database\Factories;

use Str;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;


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
            'question' => $this->faker->text,
            'created_at' => now(),
            'updated_at' => now()
        ];
        
    }
}

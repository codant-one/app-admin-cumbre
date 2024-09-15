<?php

namespace Database\Factories;

use Str;
use App\Models\Talk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class TalkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Talk::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rand = rand(1, 4);

        return [
            'category_id' => rand(10, 19),
            'schedule_id' => $rand,
            'title_es' => $this->faker->text,
            'title_en' => $this->faker->text,
            'date' => now()->toDateString(),
            'hour' => now()->toTimeString(),
            'image' => 'talks/' . $this->faker->file(public_path('images/schedules/model'.$rand), storage_path('app/public/talks'), false),
            'created_at' => now(),
            'updated_at' => now()
        ];
        
    }
}
